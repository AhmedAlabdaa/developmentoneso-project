<?php

namespace App\Queries;

use App\Models\AmContractMovment;
use App\Models\AmReturnMaid;
use Illuminate\Support\Facades\DB;
use App\Enum\MCStatus;

class AmReturnMaidQuery
{
    /**
     * Get return maids with filters and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getReturnMaids(array $filters = [], int $perPage = 15)
    {
        $query = AmReturnMaid::with([
            'contractMovment.primaryContract.crm',
            'contractMovment.employee',
        ]) 
        ->whereIn('status', [MCStatus::Pending, MCStatus::ReturnToOffice])
        ;

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

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['action']) && $filters['action'] !== '') {
            $query->where('action', $filters['action']);
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

        $sortBy = $filters['sort_by'] ?? 'date';
        $sortDir = $filters['sort_direction'] ?? 'desc';

        $allowedSorts = ['id', 'date', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'date';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    /**
     * Get a specific contract movement by ID.
     *
     * @param int $id
     * @return AmContractMovment
     */
    public function getMovmentById($id)
    {
        return AmContractMovment::with(['primaryContract.crm', 'employee', 'installments', 'returnInfo'])
            ->findOrFail($id);
    }

    /**
     * Get a specific return maid record by ID.
     *
     * @param int $id
     * @return AmReturnMaid
     */
    public function getById($id)
    {
        return AmReturnMaid::with([
            'contractMovment.primaryContract.crm',
            'contractMovment.employee',
        ])->findOrFail($id);
    }
}
