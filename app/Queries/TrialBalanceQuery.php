<?php

namespace App\Queries;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TrialBalanceQuery
{
    protected $query;

    public function __construct()
    {
        $this->query = DB::table('journal_tran_lines')
            ->join('ledger_of_accounts', 'journal_tran_lines.ledger_id', '=', 'ledger_of_accounts.id')
            ->select(
                'ledger_of_accounts.id as ledger_id',
                'ledger_of_accounts.name as ledger_name',
                'ledger_of_accounts.class',
                'ledger_of_accounts.sub_class',
                'ledger_of_accounts.group',
                DB::raw('SUM(journal_tran_lines.debit) as total_debit'),
                DB::raw('SUM(journal_tran_lines.credit) as total_credit'),
                DB::raw('SUM(journal_tran_lines.debit) - SUM(journal_tran_lines.credit) as closing_balance')
            )
            ->groupBy(
                'ledger_of_accounts.id',
                'ledger_of_accounts.name',
                'ledger_of_accounts.class',
                'ledger_of_accounts.sub_class',
                'ledger_of_accounts.group'
            );
    }

    /**
     * Filter by posting date range from journal header
     */
    public function filterByDateRange($from = null, $to = null): self
    {
        if ($from || $to) {
            $this->query->join('journal_headers', 'journal_tran_lines.journal_header_id', '=', 'journal_headers.id');
            
            if ($from) {
                $this->query->where('journal_headers.posting_date', '>=', Carbon::parse($from)->startOfDay());
            }
            if ($to) {
                $this->query->where('journal_headers.posting_date', '<=', Carbon::parse($to)->endOfDay());
            }
        }

        return $this;
    }

    /**
     * Exclude ledgers with zero closing balance
     */
    public function excludeZeroBalances(): self
    {
        $this->query->havingRaw('SUM(journal_tran_lines.debit) - SUM(journal_tran_lines.credit) != 0');

        return $this;
    }

    /**
     * Order by class, group, sub_class, ledger name
     */
    public function orderByHierarchy(): self
    {
        $this->query
            ->orderBy('ledger_of_accounts.class')
            ->orderBy('ledger_of_accounts.group')
            ->orderBy('ledger_of_accounts.sub_class')
            ->orderBy('ledger_of_accounts.name');

        return $this;
    }

    /**
     * Filter by spacial column
     */
    public function filterBySpacial($spacial = null): self
    {
        if ($spacial !== null) {
            $this->query->where('ledger_of_accounts.spacial', $spacial);
        }

        return $this;
    }

    /**
     * Apply all filters from request array
     */
    public function applyFilters(array $filters): self
    {
        $this->filterByDateRange(
            $filters['posting_date_from'] ?? null,
            $filters['posting_date_to'] ?? null
        );

        $this->filterBySpacial($filters['spacial'] ?? null);

        return $this;
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
    public function getQuery()
    {
        return $this->query;
    }
}
