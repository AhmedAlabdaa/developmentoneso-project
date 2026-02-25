<?php

namespace App\Queries;

use App\Models\DeductionPayroll;

class DeductionPayrollQuery
{
    public function getDeductionPayrolls(array $filters = [], int $perPage = 15)
    {
        $query = DeductionPayroll::with(['employee', 'createdBy', 'updatedBy']);

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (!empty($filters['payroll_year'])) {
            $query->where('payroll_year', $filters['payroll_year']);
        }

        if (!empty($filters['payroll_month'])) {
            $query->where('payroll_month', $filters['payroll_month']);
        }

        if (!empty($filters['deduction_date_from'])) {
            $query->whereDate('deduction_date', '>=', $filters['deduction_date_from']);
        }

        if (!empty($filters['deduction_date_to'])) {
            $query->whereDate('deduction_date', '<=', $filters['deduction_date_to']);
        }

        if (!empty($filters['search'])) {
            $query->where('note', 'like', "%{$filters['search']}%");
        }

        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDir = $filters['sort_direction'] ?? 'desc';
        $allowedSorts = ['id', 'payroll_year', 'payroll_month', 'deduction_date', 'amount_deduction', 'amount_allowance', 'created_at'];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    public function getById(int $id): DeductionPayroll
    {
        return DeductionPayroll::with(['employee', 'createdBy', 'updatedBy'])->findOrFail($id);
    }
}

