<?php

namespace App\Queries;

use App\Models\AmReturnMaid;
use App\Enum\MCStatus;

class AmIncidentQuery
{
    /**
     * Get incidents with filters and pagination.
     * Only returns records with RanAway, Cancelled, or Hold status.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getIncidents(array $filters = [], int $perPage = 15)
    {
        $query = AmReturnMaid::with([
            'contractMovment.primaryContract.crm',
            'contractMovment.employee',
        ]);

        // Default to incident statuses if not specified
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        } else {
            $query->whereIn('status', [
                MCStatus::RanAway,
                MCStatus::Cancelled,
                MCStatus::Hold,
            ]);
        }

        if (!empty($filters['contract_id'])) {
            $query->whereHas('contractMovment', function ($q) use ($filters) {
                $q->where('am_contract_id', $filters['contract_id']);
            });
        }

        if (!empty($filters['employee_id'])) {
            $query->whereHas('contractMovment', function ($q) use ($filters) {
                $q->where('employee_id', $filters['employee_id']);
            });
        }

        if (!empty($filters['employee_name'])) {
            $query->whereHas('contractMovment.employee', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['employee_name']}%");
            });
        }

        if (!empty($filters['customer_name'])) {
            $query->whereHas('contractMovment.primaryContract.crm', function ($q) use ($filters) {
                $q->where('first_name', 'like', "%{$filters['customer_name']}%")
                  ->orWhere('last_name', 'like', "%{$filters['customer_name']}%");
            });
        }

        if (!empty($filters['crm_id'])) {
            $query->whereHas('contractMovment.primaryContract', function ($q) use ($filters) {
                $q->where('crm_id', $filters['crm_id']);
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['search'])) {
            $query->where('note', 'like', "%{$filters['search']}%");
        }

        if (isset($filters['action']) && $filters['action'] !== '') {
            $query->where('action', $filters['action']);
        }

        $sortBy = $filters['sort_by'] ?? 'date';
        $sortDir = $filters['sort_direction'] ?? 'desc';

        $allowedSorts = ['id', 'date', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'date';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    /**
     * Get a specific incident record by ID.
     *
     * @param int $id
     * @return AmReturnMaid
     */
    public function getById($id)
    {
        return AmReturnMaid::with([
            'contractMovment.primaryContract.crm',
            'contractMovment.employee',
        ])
        ->whereIn('status', [
             MCStatus::RanAway,
             MCStatus::Cancelled,
             MCStatus::Hold,
             MCStatus::Pending, // Allow showing pending if it's considered an incident
             MCStatus::ReturnToOffice
        ])
        ->findOrFail($id);
    }
}
