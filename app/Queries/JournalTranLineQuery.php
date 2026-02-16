<?php

namespace App\Queries;

use App\Models\JournalTranLine;
use App\Enum\JournalStatus;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class JournalTranLineQuery
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = JournalTranLine::query();
    }

    /**
     * Apply eager loading for relationships
     */
    public function withRelations(array $relations = []): self
    {
        $defaultRelations = [
            'header.source',
            'ledger',
            'employee',
        ];

        $this->query->with($relations ?: $defaultRelations);

        return $this;
    }

    /**
     * Filter by journal header ID
     */
    public function filterByJournalHeaderId($headerId): self
    {
        if ($headerId !== null) {
            $this->query->where('journal_header_id', $headerId);
        }

        return $this;
    }

    /**
     * Filter by ledger ID
     */
    public function filterByLedgerId($ledgerId): self
    {
        if ($ledgerId !== null) {
            $this->query->where('ledger_id', $ledgerId);
        }

        return $this;
    }

    /**
     * Filter by candidate/employee ID
     */
    public function filterByCandidateId($candidateId): self
    {
        if ($candidateId !== null) {
            $this->query->where('candidate_id', $candidateId);
        }

        return $this;
    }

    /**
     * Filter by journal header status (Posted = 1)
     */
    public function filterByHeaderStatus($status): self
    {
        if ($status !== null) {
            $this->query->whereHas('header', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        return $this;
    }

    /**
     * Filter only posted journal entries (status = 1)
     */
    public function onlyPosted(): self
    {
        $this->query->whereHas('header', function ($q) {
            $q->where('status', JournalStatus::Posted->value);
        });

        return $this;
    }

    /**
     * Filter by posting date range from journal header
     */
    public function filterByPostingDateRange($from = null, $to = null): self
    {
        if ($from || $to) {
            $this->query->whereHas('header', function ($q) use ($from, $to) {
                if ($from) {
                    $q->where('posting_date', '>=', Carbon::parse($from)->startOfDay());
                }
                if ($to) {
                    $q->where('posting_date', '<=', Carbon::parse($to)->endOfDay());
                }
            });
        }

        return $this;
    }

    /**
     * Filter by debit/credit type
     */
    public function filterByType($type): self
    {
        if ($type === 'debit') {
            $this->query->where('debit', '>', 0);
        } elseif ($type === 'credit') {
            $this->query->where('credit', '>', 0);
        }

        return $this;
    }

    /**
     * Search across notes
     */
    public function search($searchTerm): self
    {
        if ($searchTerm) {
            $this->query->where(function ($q) use ($searchTerm) {
                $q->where('note', 'like', "%{$searchTerm}%")
                    ->orWhereHas('ledger', function ($ledgerQuery) use ($searchTerm) {
                        $ledgerQuery->where('name', 'like', "%{$searchTerm}%");
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
            'id', 'journal_header_id', 'ledger_id', 'debit', 
            'credit', 'created_at', 'updated_at'
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
        $this->filterByJournalHeaderId($filters['journal_header_id'] ?? null)
            ->filterByLedgerId($filters['ledger_id'] ?? null)
            ->filterByCandidateId($filters['candidate_id'] ?? null)
            ->filterByHeaderStatus($filters['status'] ?? null)
            ->filterByPostingDateRange($filters['posting_date_from'] ?? null, $filters['posting_date_to'] ?? null)
            ->filterByType($filters['type'] ?? null)
            ->search($filters['search'] ?? null);

        // Apply only_posted filter if set
        if (isset($filters['only_posted']) && $filters['only_posted']) {
            $this->onlyPosted();
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
