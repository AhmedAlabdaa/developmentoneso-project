<?php

namespace App\Services;

use App\Models\JournalTranLine;
use App\Models\LedgerOfAccount;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LedgerOfAccountService
{
    public function getPaginatedLedgers(
        array $filters = [],
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator {
        $query = LedgerOfAccount::query()->with(['createdBy', 'updatedBy']);

        $this->applyFilters($query, $filters);
        $this->applySorting($query, $sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    protected function applyFilters(Builder $query, array $filters): void
    {
        $query
            ->when($filters['name'] ?? null, fn ($q, $v) =>
                $q->where('name', 'like', "%{$v}%")
            )
            ->when(isset($filters['class']), fn ($q) =>
                $q->where('class', $filters['class'])
            )
            ->when(isset($filters['sub_class']), fn ($q) =>
                $q->where('sub_class', $filters['sub_class'])
            )
            ->when($filters['group'] ?? null, fn ($q, $v) =>
                $q->where('group', $v)
            )
            ->when(isset($filters['spacial']), fn ($q) =>
                $q->where('spacial', $filters['spacial'])
            )
            ->when($filters['type'] ?? null, fn ($q, $v) =>
                $q->where('type', $v)
            )
            ->when($filters['created_by'] ?? null, fn ($q, $v) =>
                $q->where('created_by', $v)
            )
            ->when($filters['created_from'] ?? null, function ($q, $v) {
                $from = Carbon::parse($v)->startOfDay();
                $q->where('created_at', '>=', $from);
            })
            ->when($filters['created_to'] ?? null, function ($q, $v) {
                $to = Carbon::parse($v)->endOfDay();
                $q->where('created_at', '<=', $to);
            })
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                        ->orWhere('group', 'like', "%{$search}%")
                        ->orWhere('note', 'like', "%{$search}%");
                });
            });
    }

    protected function applySorting(Builder $query, string $sortBy, string $sortDirection): void
    {
        $allowedSortFields = [
            'id', 'name', 'class', 'sub_class', 'group', 'spacial',
            'type', 'created_at', 'updated_at',
        ];

        if (!in_array($sortBy, $allowedSortFields, true)) {
            $sortBy = 'created_at';
        }

        $sortDirection = strtolower($sortDirection);
        if (!in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);
    }

    public function getLedgerById(int $id): ?LedgerOfAccount
    {
        return LedgerOfAccount::with(['createdBy', 'updatedBy'])->find($id);
    }

    public function createLedger(array $data): LedgerOfAccount
    {
        $data['created_by'] = Auth::id() ?? 1;
        $data['updated_by'] = Auth::id() ?? 1;

        return LedgerOfAccount::create($data)->load(['createdBy', 'updatedBy']);
    }

    public function updateLedger(int $id, array $data): ?LedgerOfAccount
    {
        $ledger = LedgerOfAccount::find($id);
        if (!$ledger) {
            return null;
        }

        $data['updated_by'] = Auth::id() ?? 1;

        $ledger->update($data);

        return $ledger->fresh(['createdBy', 'updatedBy']);
    }

    public function deleteLedger(int $id): bool
    {
        // Check if the ledger is referenced in JournalTranLine
        $isReferenced = JournalTranLine::where('ledger_id', $id)->exists();
        
        if ($isReferenced) {
            throw new \DomainException('Ledger is referenced in JournalTranLine and cannot be deleted.');
        }
        
        return (bool) LedgerOfAccount::whereKey($id)->delete();
    }

    public function lookupCustomers(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        $query = LedgerOfAccount::query()
            ->select(
                'ledger_of_accounts.id', 
                'ledger_of_accounts.name', 
                'ledger_of_accounts.group',
                'crm.first_name',
                'crm.last_name', 
                'crm.mobile',
                'crm.CL_Number'
            )
            ->leftJoin('crm', 'ledger_of_accounts.id', '=', 'crm.ledger_id')
            ->where('ledger_of_accounts.spacial', 3); // Customers only

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Search Ledger Name
                $q->where('ledger_of_accounts.name', 'like', "%{$search}%")
                  // Search CRM fields
                  ->orWhere('crm.first_name', 'like', "%{$search}%")
                  ->orWhere('crm.last_name', 'like', "%{$search}%")
                  ->orWhere('crm.mobile', 'like', "%{$search}%")
                  ->orWhere('crm.CL_Number', 'like', "%{$search}%");
            });
        }

        $query->orderBy('ledger_of_accounts.name', 'asc');

        return $query->paginate($perPage);
    }
}
