<?php

namespace App\Queries;

use App\Models\InvoiceService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class InvoiceServiceQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = InvoiceService::query();
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'lines.ledger',
            'creator',
            'updater'
        ];

        $this->query->with($relations ?: $defaultRelations);

        return $this;
    }

    /**
     * Filter by status
     */
    public function filterByStatus($status): self
    {
        if ($status !== null) {
            $this->query->where('status', filter_var($status, FILTER_VALIDATE_BOOLEAN));
        }

        return $this;
    }

    /**
     * Filter by type
     */
    public function filterByType($type): self
    {
        if ($type) {
            $this->query->where('type', $type);
        }

        return $this;
    }

    /**
     * Search across multiple fields
     */
    public function search($searchTerm): self
    {
        if ($searchTerm) {
            $this->query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('code', 'like', "%{$searchTerm}%")
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
            'id', 'name', 'code', 'type', 'status', 'created_at', 'updated_at'
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
        $this->filterByStatus($filters['status'] ?? null)
            ->filterByType($filters['type'] ?? null)
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
     * Get the underlying query builder
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }
}
