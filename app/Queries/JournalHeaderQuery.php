<?php

namespace App\Queries;

use App\Models\JournalHeader;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class JournalHeaderQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = JournalHeader::query();
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'lines.ledger',
            'lines.employee',
            'source',
            'preSrc',
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
            $this->query->where('status', $status);
        }

        return $this;
    }

    /**
     * Filter by posting date range
     */
    public function filterByPostingDateRange($from = null, $to = null): self
    {
        if ($from) {
            $this->query->where('posting_date', '>=', Carbon::parse($from)->startOfDay());
        }

        if ($to) {
            $this->query->where('posting_date', '<=', Carbon::parse($to)->endOfDay());
        }

        return $this;
    }

    /**
     * Filter by source type
     */
    public function filterBySourceType($sourceType): self
    {
        if ($sourceType) {
            $this->query->where('source_type', $sourceType);
        }

        return $this;
    }

    /**
     * Filter by source ID
     */
    public function filterBySourceId($sourceId): self
    {
        if ($sourceId) {
            $this->query->where('source_id', $sourceId);
        }

        return $this;
    }

    /**
     * Filter by created by user
     */
    public function filterByCreatedBy($userId): self
    {
        if ($userId) {
            $this->query->where('created_by', $userId);
        }

        return $this;
    }

    /**
     * Filter by posted by user
     */
    public function filterByPostedBy($userId): self
    {
        if ($userId) {
            $this->query->where('posted_by', $userId);
        }

        return $this;
    }

    /**
     * Filter by created date range
     */
    public function filterByCreatedDateRange($from = null, $to = null): self
    {
        if ($from) {
            $this->query->where('created_at', '>=', Carbon::parse($from)->startOfDay());
        }

        if ($to) {
            $this->query->where('created_at', '<=', Carbon::parse($to)->endOfDay());
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
                $q->where('note', 'like', "%{$searchTerm}%")
                    ->orWhereHas('lines', function ($lineQuery) use ($searchTerm) {
                        $lineQuery->where('note', 'like', "%{$searchTerm}%");
                    });
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
            'id', 'posting_date', 'status', 'total_debit', 
            'total_credit', 'created_at', 'updated_at', 'posted_at'
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
            ->filterByPostingDateRange($filters['posting_date_from'] ?? null, $filters['posting_date_to'] ?? null)
            ->filterBySourceType($filters['source_type'] ?? null)
            ->filterBySourceId($filters['source_id'] ?? null)
            ->filterByCreatedBy($filters['created_by'] ?? null)
            ->filterByPostedBy($filters['posted_by'] ?? null)
            ->filterByCreatedDateRange($filters['created_from'] ?? null, $filters['created_to'] ?? null)
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
