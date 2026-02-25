<?php

namespace App\Services;

use App\Models\AmInstallment;
use Illuminate\Support\Facades\DB;
use Exception;

class AmInstallmentService
{
    /**
     * Create a new installment.
     *
     * @param array $data
     * @return AmInstallment
     * @throws Exception
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $installment = AmInstallment::create([
                'date' => $data['date'],
                'am_movment_id' => $data['am_movment_id'],
                'amount' => $data['amount'] ?? 0,
                'note' => $data['note'] ?? null,
                'status' => $data['status'] ?? 0,
            ]);

            DB::commit();

            return $installment->load(['contractMovment.primaryContract.crm', 'contractMovment.employee']);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing installment.
     *
     * @param AmInstallment $installment
     * @param array $data
     * @return AmInstallment
     * @throws Exception
     */
    public function update(AmInstallment $installment, array $data)
    {
        DB::beginTransaction();

        try {
            $installment->update(array_filter([
                'date' => $data['date'] ?? null,
                'amount' => $data['amount'] ?? null,
                'note' => $data['note'] ?? null,
                'status' => $data['status'] ?? null,
            ], fn($v) => !is_null($v)));

            DB::commit();

            return $installment->refresh()->load(['contractMovment.primaryContract.crm', 'contractMovment.employee']);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete an installment.
     *
     * @param AmInstallment $installment
     * @return bool
     * @throws Exception
     */
    public function delete(AmInstallment $installment)
    {
        DB::beginTransaction();

        try {
            $installment->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
