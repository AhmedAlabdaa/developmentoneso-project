<?php

namespace App\Services\ReturnMaid;

use App\Enum\MCStatus;
use App\Models\AmContractMovment;
use App\Models\AmReturnMaid;
use App\Models\Amp3ActionNotify;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class AmReturnMaidService
{
    private const RETURN_MOVEMENT_RELATIONS = [
        'primaryContract.crm',
        'employee',
        'installments',
        'returnInfo',
    ];

    public function __construct(
        private ReplacementActionService $replacementActionService,
        private RefundActionService $refundActionService
    ) {
    }

    public function returnContract(AmContractMovment $movement, array $data): AmContractMovment
    {
        return DB::transaction(function () use ($movement, $data) {
            $status = isset($data['status']) ? MCStatus::from($data['status']) : MCStatus::ReturnToOffice;

            AmReturnMaid::create([
                'date' => $data['date'],
                'am_movment_id' => $movement->id,
                'note' => $data['note'] ?? null,
                'status' => $status,
                'action' => $data['action'] ?? null,
                'created_by' => auth()->id(),
            ]);

            $movement->update(['status' => 0]);
            $movement->primaryContract->update(['status' => 0]);

            if ($status === MCStatus::ReturnToOffice) {
                Employee::where('id', $movement->employee_id)->update(['inside_status' => 1]);
            }

            return $movement->refresh()->load(self::RETURN_MOVEMENT_RELATIONS);
        });
    }

    public function updateReturn(AmReturnMaid $returnMaid, array $data): AmReturnMaid
    {
        return DB::transaction(function () use ($returnMaid, $data) {
            $oldStatus = $returnMaid->status;

            $updateData = array_filter([
                'date' => $data['date'] ?? null,
                'note' => $data['note'] ?? null,
                'status' => isset($data['status']) ? MCStatus::from($data['status']) : null,
                'action' => $data['action'] ?? null,
            ], fn($v) => !is_null($v));

            $returnMaid->update($updateData);

            if ($returnMaid->status === MCStatus::ReturnToOffice && $oldStatus !== MCStatus::ReturnToOffice) {
                Employee::where('id', $returnMaid->contractMovment->employee_id)->update(['inside_status' => 1]);
            }

            return $returnMaid->refresh()->load([
                'contractMovment.primaryContract.crm',
                'contractMovment.employee',
            ]);
        });
    }

    public function deleteReturn(AmReturnMaid $returnMaid): bool
    {
        return DB::transaction(function () use ($returnMaid) {
            $returnMaid->delete();
            return true;
        });
    }

    public function replaceReturnedMaid(AmReturnMaid $returnMaid, array $data): AmContractMovment
    {
        return DB::transaction(function () use ($returnMaid, $data) {
            $this->replacementActionService->makeReplacement($returnMaid);

            return $this->replacementActionService->executeReplacement([
                'old_movement_id' => $returnMaid->am_movment_id,
                'new_employee_id' => $data['new_employee_id'],
                'date' => $data['date'] ?? null,
            ]);
        });
    }

    public function raiseRefund(array $data, ?int $returnMaidId = null): AmReturnMaid|Amp3ActionNotify
    {
        return $this->refundActionService->createRefund($data, $returnMaidId);
    }

    public function updateActionNotify(Amp3ActionNotify $actionNotify, array $data): Amp3ActionNotify
    {
        return DB::transaction(function () use ($actionNotify, $data) {
            return $this->refundActionService->updateActionNotify($actionNotify, $data);
        });
    }

    public function deleteActionNotify(Amp3ActionNotify $actionNotify): bool
    {
        return DB::transaction(function () use ($actionNotify) {
            return (bool) $actionNotify->delete();
        });
    }
}
