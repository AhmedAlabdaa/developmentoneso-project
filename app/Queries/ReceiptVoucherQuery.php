<?php

namespace App\Queries;

use App\Models\ReceiptVoucher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ReceiptVoucherQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = ReceiptVoucher::query();
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'source',
            'journal.lines.ledger',
        ];

        $this->query->with($relations ?: $defaultRelations);

        return $this;
    }

    /**
     * Search across multiple fields
     */
    public function search($searchTerm): self
    {
        if ($searchTerm) {
            $this->query->where(function ($q) use ($searchTerm) {
                $q->where('serial_number', 'like', "%{$searchTerm}%");
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
            'id', 'serial_number', 'status', 'payment_mode', 'created_at', 'updated_at'
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
        $this->search($filters['search'] ?? null);

        if (isset($filters['status'])) {
            $this->query->where('status', $filters['status']);
        }

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
     * Get all results
     */
    public function get()
    {
        return $this->query->get();
    }

    /**
     * Get the underlying query builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }
}
