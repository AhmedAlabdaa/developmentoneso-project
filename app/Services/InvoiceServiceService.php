<?php

namespace App\Services;

use App\Models\InvoiceService;
use App\Models\InvoiceServiceLine;
use App\Queries\InvoiceServiceQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceServiceService
{
    /**
     * Get paginated invoice services with filtering and sorting
     */
    public function getPaginatedList(
        array $filters = [],
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator {
        $query = new InvoiceServiceQuery();

        return $query
            ->withRelations()
            ->applyFilters($filters)
            ->sortBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Get a single invoice service by ID with details
     */
    public function getById(int $id): ?InvoiceService
    {
        return InvoiceService::with(['lines.ledger', 'creator', 'updater'])->find($id);
    }

    /**
     * Create a new invoice service with lines
     */
    public function create(array $data): InvoiceService
    {
        return DB::transaction(function () use ($data) {
            $linesData = $data['lines'] ?? [];
            unset($data['lines']);

            $data['created_by'] = Auth::id();
            
            $invoiceService = InvoiceService::create($data);

            foreach ($linesData as $lineData) {
                // Ensure ledger_account_id is present
                if (isset($lineData['ledger_account_id'])) {
                    $invoiceService->lines()->create($lineData);
                }
            }

            return $invoiceService->fresh(['lines.ledger']);
        });
    }

    /**
     * Update an existing invoice service with lines
     */
    public function update(int $id, array $data): ?InvoiceService
    {
        $invoiceService = InvoiceService::find($id);

        if (!$invoiceService) {
            return null;
        }

        return DB::transaction(function () use ($invoiceService, $data) {
            $linesData = $data['lines'] ?? null;
            unset($data['lines']);

            $data['updated_by'] = Auth::id();
            $invoiceService->update($data);

            if ($linesData !== null) {
                $this->syncLines($invoiceService, $linesData);
            }

            return $invoiceService->fresh(['lines.ledger']);
        });
    }

    /**
     * Delete an invoice service
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $invoiceService = InvoiceService::find($id);

            if (!$invoiceService) {
                return false;
            }

            // Lines are cascade on delete DB level, but good to be explicit or let DB handle it.
            // Migration says: ->cascadeOnDelete() for lines.
            // So simply deleting the parent is enough.
            
            return $invoiceService->delete();
        });
    }

    /**
     * Sync lines (create/update/delete)
     */
    protected function syncLines(InvoiceService $invoiceService, array $linesData): void
    {
        $existingIds = $invoiceService->lines()->pluck('id')->toArray();
        $keptIds = [];

        foreach ($linesData as $lineData) {
            if (isset($lineData['id']) && in_array($lineData['id'], $existingIds)) {
                // Update existing
                $line = InvoiceServiceLine::find($lineData['id']);
                $line->update($lineData);
                $keptIds[] = $lineData['id'];
            } else {
                // Create new
                $invoiceService->lines()->create($lineData);
            }
        }

        // Delete removed lines
        $idsToDelete = array_diff($existingIds, $keptIds);
        if (!empty($idsToDelete)) {
            InvoiceServiceLine::destroy($idsToDelete);
        }
    }
}
