<?php

namespace App\Queries;

use App\Models\AmInstallment;

class AmInstallmentQuery
{
    /**
     * Get installments with filters and pagination.
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getInstallments(array $filters = [], int $perPage = 15)
    {
        $query = AmInstallment::with(['contractMovment.primaryContract.crm', 'contractMovment.employee']);

        if (!empty($filters['am_movment_id'])) {
            $query->where('am_movment_id', $filters['am_movment_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
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

        $sortBy = $filters['sort_by'] ?? 'date';
        $sortDir = $filters['sort_direction'] ?? 'desc';

        $allowedSorts = ['id', 'date', 'amount', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'date';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    /**
     * Get a specific installment by ID with relations.
     *
     * @param int $id
     * @return AmInstallment
     */
    public function getById($id)
    {
        return AmInstallment::with(['contractMovment.primaryContract.crm', 'contractMovment.employee'])
            ->findOrFail($id);
    }
}
