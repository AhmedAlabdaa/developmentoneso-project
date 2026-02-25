<?php

namespace App\Services;

use App\Models\AmContractMovment;
use Illuminate\Support\Facades\DB;
use Exception;

class AmContractMovementService
{
    /**
     * Update an existing contract movement.
     *
     * @param AmContractMovment $movement
     * @param array $data
     * @return AmContractMovment
     * @throws Exception
     */
    public function update(AmContractMovment $movement, array $data)
    {
        DB::beginTransaction();

        try {
            $movement->update(array_filter([
                'date' => $data['date'] ?? null,
                'employee_id' => $data['employee_id'] ?? null,
                'note' => $data['note'] ?? null,
            ], fn($v) => !is_null($v)));

            // Handle nested installments
            if (isset($data['installments']) && is_array($data['installments'])) {
                $incomingInstallmentIds = collect($data['installments'])
                    ->pluck('id')
                    ->filter(fn($id) => !is_null($id))
                    ->map(fn($id) => (int) $id)
                    ->values()
                    ->all();

                // Remove pending installments that were deleted from UI payload.
                $movement->installments()
                    ->where('status', 0)
                    ->when(
                        !empty($incomingInstallmentIds),
                        fn($query) => $query->whereNotIn('id', $incomingInstallmentIds)
                    )
                    ->delete();

                foreach ($data['installments'] as $installmentData) {
                    if (isset($installmentData['id'])) {
                        // Update existing installment
                        $movement->installments()->where('id', $installmentData['id'])
                        ->where('status', 0)
                        ->update(array_filter([
                            'date' => $installmentData['date'] ?? null,
                            'amount' => $installmentData['amount'] ?? null,
                            'note' => $installmentData['note'] ?? null,
                        ], fn($v) => !is_null($v)));
                    } else {
                        // Create new installment
                        $movement->installments()->create([
                            'date' => $installmentData['date'] ?? date('Y-m-d'),
                            'amount' => $installmentData['amount'] ?? 0,
                            'note' => $installmentData['note'] ?? null,
                            'status' => 0, // Default to pending, don't allow setting from request
                        ]);
                    }
                }
            }

            DB::commit();

            return $movement->refresh()->load(['primaryContract.crm', 'employee', 'installments', 'returnInfo']);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a contract movement.
     *
     * @param AmContractMovment $movement
     * @return bool
     * @throws Exception
     */
    public function delete(AmContractMovment $movement)
    {
        DB::beginTransaction();

        try {
            $movement->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
