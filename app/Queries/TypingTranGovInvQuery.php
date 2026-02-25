<?php

namespace App\Queries;

use App\Models\TypingTranGovInv;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TypingTranGovInvQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = TypingTranGovInv::query();
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'journal',
            'ledger.crm',
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
                $q->where('serial_no', 'like', "%{$searchTerm}%")
                  ->orWhere('gov_dw_no', 'like', "%{$searchTerm}%");
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
            'id', 'serial_no', 'gov_dw_no', 'created_at', 'updated_at'
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
