<?php

namespace App\Services;

use App\Models\JournalHeader;
use App\Models\JournalTranLine;
use App\Queries\JournalHeaderQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JournalHeaderService
{
    /**
     * Get paginated journals with filtering and sorting
     */
    public function getPaginatedJournals(
        array $filters = [],
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator {
        $query = new JournalHeaderQuery();

        return $query
            ->withRelations()
            ->applyFilters($filters)
            ->sortBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Get a single journal by ID with nested lines
     */
    public function getJournalById(int $id): ?JournalHeader
    {
        return JournalHeader::with([
            'lines.ledger',
            'lines.employee',
            'source',
            'preSrc',
        ])->find($id);
    }

    /**
     * Create a new journal with nested lines
     */
    public function createJournal(array $data): JournalHeader
    {
        return DB::transaction(function () use ($data) {
            // Extract lines data
            $linesData = $data['lines'] ?? [];
            unset($data['lines']);

            // Validate balanced entries
            $this->validateBalancedEntries($linesData);

            // Calculate totals from lines
            $totals = $this->calculateTotals($linesData);
            $data['total_debit'] = $totals['debit'];
            $data['total_credit'] = $totals['credit'];
            $data['created_by'] = Auth::id() ?? 1;

            // Create the header
            $journal = JournalHeader::create($data);

            // Create the lines
            foreach ($linesData as $lineData) {
                $lineData['journal_header_id'] = $journal->id;
                $lineData['created_by'] = Auth::id() ?? 1;
                JournalTranLine::create($lineData);
            }

            // Reload with relationships
            return $journal->fresh([
                'lines.ledger',
                'lines.employee',
                'source',
                'preSrc',
            ]);
        });
    }

    /**
     * Update an existing journal with nested lines
     */
    public function updateJournal(int $id, array $data): ?JournalHeader
    {
        $journal = JournalHeader::find($id);
        
        if (!$journal) {
            return null;
        }

        return DB::transaction(function () use ($journal, $data) {
            // Extract lines data
            $linesData = $data['lines'] ?? null;
            unset($data['lines']);

            // Update header fields
            if (!empty($data)) {
                $journal->update($data);
            }

            // Update lines if provided
            if ($linesData !== null) {
                // Validate balanced entries
                $this->validateBalancedEntries($linesData);

                $this->syncLines($journal, $linesData);

                // Recalculate totals
                $totals = $this->calculateTotals($linesData);
                $journal->update([
                    'total_debit' => $totals['debit'],
                    'total_credit' => $totals['credit'],
                ]);
            }

            // Reload with relationships
            return $journal->fresh([
                'lines.ledger',
                'lines.employee',
                'source',
                'preSrc',
            ]);
        });
    }

    /**
     * Delete a journal and its lines
     */
    public function deleteJournal(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $journal = JournalHeader::find($id);
            
            if (!$journal) {
                return false;
            }

            // Delete lines first
            $journal->lines()->delete();

            // Delete header
            return $journal->delete();
        });
    }

    /**
     * Sync lines for a journal (create, update, delete)
     */
    protected function syncLines(JournalHeader $journal, array $linesData): void
    {
        $existingLineIds = $journal->lines()->pluck('id')->toArray();
        $updatedLineIds = [];

        foreach ($linesData as $lineData) {
            if (isset($lineData['id']) && $lineData['id']) {
                // Update existing line
                $line = JournalTranLine::find($lineData['id']);
                if ($line && $line->journal_header_id == $journal->id) {
                    $line->update($lineData);
                    $updatedLineIds[] = $line->id;
                }
            } else {
                // Create new line
                $lineData['journal_header_id'] = $journal->id;
                $lineData['created_by'] = Auth::id() ?? 1;
                $line = JournalTranLine::create($lineData);
                $updatedLineIds[] = $line->id;
            }
        }

        // Delete lines that were removed
        $linesToDelete = array_diff($existingLineIds, $updatedLineIds);
        if (!empty($linesToDelete)) {
            JournalTranLine::whereIn('id', $linesToDelete)->delete();
        }
    }

    /**
     * Validate that journal entries are balanced (debits = credits)
     *
     * @throws \InvalidArgumentException
     */
    protected function validateBalancedEntries(array $linesData): void
    {
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($linesData as $line) {
            $totalDebit += (float) ($line['debit'] ?? 0);
            $totalCredit += (float) ($line['credit'] ?? 0);
        }

        $totalDebit = round($totalDebit, 2);
        $totalCredit = round($totalCredit, 2);

        if ($totalDebit !== $totalCredit) {
            throw new \InvalidArgumentException(
                "Journal entries must be balanced. Total debits ({$totalDebit}) must equal total credits ({$totalCredit})."
            );
        }
    }

    /**
     * Calculate total debit and credit from lines
     */
    protected function calculateTotals(array $linesData): array
    {
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($linesData as $line) {
            $totalDebit += (float) ($line['debit'] ?? 0);
            $totalCredit += (float) ($line['credit'] ?? 0);
        }

        return [
            'debit' => round($totalDebit, 2),
            'credit' => round($totalCredit, 2),
        ];
    }

    /**
     * Bulk update journal status
     *
     * @param array $ids Array of journal header IDs
     * @param \App\Enum\JournalStatus $status New status
     * @return int Number of updated records
     */
    public function bulkUpdateStatus(array $ids, \App\Enum\JournalStatus $status): int
    {
        $updateData = [
            'status' => $status,
        ];

        if ($status === \App\Enum\JournalStatus::Posted) {
            $updateData['posted_at'] = now();
            $updateData['posted_by'] = Auth::id() ?? 1;
        } elseif ($status === \App\Enum\JournalStatus::Draft) {
            $updateData['posted_at'] = null;
            $updateData['posted_by'] = null;
        }
        // Void status keeps original posted info if it was posted, or remains null if draft.
        // If specific behavior for Void is needed (e.g. clear posted info), add it here.

        return JournalHeader::whereIn('id', $ids)->update($updateData);
    }
}
