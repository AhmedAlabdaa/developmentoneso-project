<?php

namespace App\Services\ReturnMaid;

use App\Enum\AmReturnAction;
use App\Enum\EnumMaidStatus;
use App\Models\AmContractMovment;
use App\Models\AmReturnMaid;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\DB;

class ReplacementActionService
{
    private const RETURN_MAID_RELATIONS = [
        'contractMovment.primaryContract.crm',
        'contractMovment.employee',
    ];

    public function makeReplacement(AmReturnMaid $returnMaid): AmReturnMaid
    {
        $returnMaid->action = AmReturnAction::ReplacementRequested->value;
        $returnMaid->updated_by = auth()->id();
        $returnMaid->saveOrFail();

        return $returnMaid->refresh()->load(self::RETURN_MAID_RELATIONS);
    }

    /**
     * Execute full replacement workflow:
     * - old movement must be inactive
     * - create new movement
     * - move unpaid installments
     * - set new maid status to hired
     * - reactivate primary contract
     *
     * @param array $data
     * @return AmContractMovment
     * @throws Exception
     */
    public function executeReplacement(array $data): AmContractMovment
    {
        return DB::transaction(function () use ($data) {
            $oldMovement = AmContractMovment::findOrFail($data['old_movement_id']);

            if ($oldMovement->status != 0) {
                throw new Exception('The source contract movement is not inactive.');
            }

            $newMovement = AmContractMovment::create([
                'am_contract_id' => $oldMovement->am_contract_id,
                'employee_id' => $data['new_employee_id'],
                'date' => $data['date'] ?? now()->format('Y-m-d'),
                'status' => 1,
            ]);

            $unpaidInstallments = $oldMovement->installments()->where('status', 0)->get();
            foreach ($unpaidInstallments as $installment) {
                $newMovement->installments()->create([
                    'date' => $installment->date,
                    'amount' => $installment->amount,
                    'note' => $installment->note,
                    'status' => 0,
                ]);

                $installment->delete();
            }

            Employee::where('id', $data['new_employee_id'])
                ->update(['inside_status' => EnumMaidStatus::HIRED]);

            $oldMovement->primaryContract()->update(['status' => 1]);

            return $newMovement->refresh()->load(['employee', 'installments', 'primaryContract.crm']);
        });
    }
}
