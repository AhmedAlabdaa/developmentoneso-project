<?php

namespace App\Queries;

use App\Models\AmMonthlyContractInv;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AmMonthlyInvoiceQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = AmMonthlyContractInv::query();
        $this->applyComputedColumns($this->query);
    }

    protected function applyComputedColumns(Builder $query): void
    {
        $query->select('am_monthly_contract_invs.*')
            ->selectRaw('ROUND(am_monthly_contract_invs.amount - am_monthly_contract_invs.paid_amount, 2) as unpaid_amount')
            ->selectRaw("
                CASE
                    WHEN am_monthly_contract_invs.paid_amount <= 0 THEN 'unpaid'
                    WHEN am_monthly_contract_invs.paid_amount >= am_monthly_contract_invs.amount THEN 'paid'
                    ELSE 'partial_paid'
                END as payment_status
            ")
            ->selectRaw('ROUND(am_monthly_contract_invs.amount - am_monthly_contract_invs.refunded_amount, 2) as unrefunded_amount')
            ->selectRaw("
                CASE
                    WHEN am_monthly_contract_invs.refunded_amount <= 0 THEN 'not_refunded'
                    WHEN am_monthly_contract_invs.refunded_amount >= am_monthly_contract_invs.amount THEN 'fully_refunded'
                    ELSE 'partial_refunded'
                END as refund_status
            ");
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'contractMovment.employee',
            'contractMovment.primaryContract',
            'crm',
            'installment',
            'journal.lines',
        ];

        $this->query->with($relations ?: $defaultRelations);

        return $this;
    }

    /**
     * Filter by customer (CRM)
     */
    public function filterByCrm($crmId): self
    {
        if ($crmId) {
            $this->query->where('crm_id', $crmId);
        }

        return $this;
    }

    /**
     * Filter by contract movement
     */
    public function filterByContract($contractId): self
    {
        if ($contractId) {
            $this->query->where('am_monthly_contract_id', $contractId);
        }

        return $this;
    }

    /**
     * Filter by date range
     */
    public function filterByDateRange($from, $to): self
    {
        if ($from) {
            $this->query->whereDate('date', '>=', $from);
        }
        if ($to) {
            $this->query->whereDate('date', '<=', $to);
        }

        return $this;
    }

    /**
     * Search across serial_no and note
     */
    public function search($searchTerm): self
    {
        if ($searchTerm) {
            $this->query->where(function ($q) use ($searchTerm) {
                $q->where('serial_no', 'like', "%{$searchTerm}%")
                    ->orWhere('note', 'like', "%{$searchTerm}%");
            });
        }

        return $this;
    }

    /**
     * Apply sorting
     */
    public function sortBy(string $sortBy = 'created_at', string $sortDirection = 'desc'): self
    {
        $allowedSortFields = [
            'id', 'date', 'serial_no', 'amount', 'paid_amount', 'created_at', 'updated_at'
        ];

        if (!in_array($sortBy, $allowedSortFields, true)) {
            $sortBy = 'created_at';
        }

        $sortDirection = strtolower($sortDirection);
        if (!in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $this->query->orderBy($sortBy, $sortDirection);

        return $this;
    }

    /**
     * Apply all filters from request array
     */
    public function applyFilters(array $filters): self
    {
        $this->filterByCrm($filters['crm_id'] ?? null)
            ->filterByContract($filters['am_monthly_contract_id'] ?? null)
            ->filterByDateRange($filters['date_from'] ?? null, $filters['date_to'] ?? null)
            ->search($filters['search'] ?? null);

        return $this;
    }

    /**
     * Get paginated results
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query->paginate($perPage);
    }

    /**
     * Find a single invoice by ID with relations
     */
    public function findById(int $id): ?AmMonthlyContractInv
    {
        $query = AmMonthlyContractInv::query();
        $this->applyComputedColumns($query);

        return $query->with([
            'contractMovment.employee',
            'contractMovment.primaryContract',
            'crm',
            'installment',
            'journal.lines',
        ])->findOrFail($id);
    }
}
