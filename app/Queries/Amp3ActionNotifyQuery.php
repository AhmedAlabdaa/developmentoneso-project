<?php

namespace App\Queries;

use App\Models\Amp3ActionNotify;

class Amp3ActionNotifyQuery
{
    public function getActionNotifies(array $filters = [], int $perPage = 15)
    {
        $query = Amp3ActionNotify::with(['movementContract.primaryContract.crm', 'movementContract.employee']);

        if (!empty($filters['am_contract_movement_id'])) {
            $query->where('am_contract_movement_id', $filters['am_contract_movement_id']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['refund_date_from'])) {
            $query->whereDate('refund_date', '>=', $filters['refund_date_from']);
        }

        if (!empty($filters['refund_date_to'])) {
            $query->whereDate('refund_date', '<=', $filters['refund_date_to']);
        }

        if (!empty($filters['search'])) {
            $query->where('note', 'like', "%{$filters['search']}%");
        }

        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDir = $filters['sort_direction'] ?? 'desc';
        $allowedSorts = ['id', 'refund_date', 'amount', 'status', 'created_at'];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    public function getById(int $id): Amp3ActionNotify
    {
        return Amp3ActionNotify::with(['movementContract.primaryContract.crm', 'movementContract.employee'])
            ->findOrFail($id);
    }
}
