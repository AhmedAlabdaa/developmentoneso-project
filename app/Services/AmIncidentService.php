<?php

namespace App\Services;

use App\Models\AmReturnMaid;
use App\Models\Employee;
use App\Enum\MCStatus;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Enum\EnumMaidStatus;

class AmIncidentService
{
    /**
     * Create a new incident record.
     *
     * @param array $data
     * @return AmReturnMaid
     * @throws Exception
     */
    public function createIncident(array $data)
    {
        DB::beginTransaction();

        try {
            $status = MCStatus::from($data['status']);
            
            $incident = AmReturnMaid::create([
                'date'          => $data['date'],
                'am_movment_id' => $data['am_movment_id'],
                'note'          => $data['note'] ?? null,
                'status'        => $status,
                'action'        => $data['action'] ?? null,
                'created_by'    => auth()->id(),
            ]);

       
            if (in_array($status, [MCStatus::RanAway, MCStatus::Cancelled, MCStatus::Hold])) {
                $movement = $incident->contractMovment;
                if ($movement) {
                    Employee::where('id', $movement->employee_id)
                        ->update(['inside_status' => EnumMaidStatus::INCIDENTED]);
                    
              
                    $movement->update(['status' => 0]);
                    $movement->primaryContract->update(['status' => 0]);
                }
            }

            DB::commit();

            return $incident->refresh()->load([
                'contractMovment.primaryContract.crm',
                'contractMovment.employee',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update an existing incident record.
     *
     * @param AmReturnMaid $incident
     * @param array $data
     * @return AmReturnMaid
     * @throws Exception
     */
    public function updateIncident(AmReturnMaid $incident, array $data)
    {
        DB::beginTransaction();

        try {
            $oldStatus = $incident->status;
            
            $updateData = array_filter([
                'date'   => $data['date'] ?? null,
                'note'   => $data['note'] ?? null,
                'status' => isset($data['status']) ? MCStatus::from($data['status']) : null,
                'action' => $data['action'] ?? null,
            ], fn($v) => !is_null($v));

            $incident->update($updateData);
            $newStatus = $incident->status;

            // If status changed to RanAway, Cancelled, or Hold, ensure Employee inside_status is 4
            if ($newStatus !== $oldStatus && in_array($newStatus, [MCStatus::RanAway, MCStatus::Cancelled, MCStatus::Hold])) {
                $movement = $incident->contractMovment;
                if ($movement) {
                    Employee::where('id', $movement->employee_id)
                        ->update(['inside_status' => 4]);
                }
            }

            DB::commit();

            return $incident->refresh()->load([
                'contractMovment.primaryContract.crm',
                'contractMovment.employee',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete an incident record.
     *
     * @param AmReturnMaid $incident
     * @return bool
     * @throws Exception
     */
    public function deleteIncident(AmReturnMaid $incident)
    {
        DB::beginTransaction();

        try {
            $incident->delete();
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
