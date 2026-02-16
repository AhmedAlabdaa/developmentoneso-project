<?php

namespace App\Services;

use App\Models\ReceiptVoucher;
use App\Models\NewCandidate;
use App\Queries\ReceiptVoucherQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use App\Services\JournalHeaderService;
use App\Enum\JournalStatus;

class ReceiptVoucherService
{
    public function __construct(protected JournalHeaderService $journalHeaderService)
    {
    }

    /**
     * Get paginated items with filtering and sorting
     */
    public function getPaginated(
        array $filters = [],
        int $perPage = 15,
        string $sortBy = 'created_at',
        string $sortDirection = 'desc'
    ): LengthAwarePaginator {
        $query = new ReceiptVoucherQuery();

        return $query
            ->withRelations()
            ->applyFilters($filters)
            ->sortBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Get a single item by ID
     */
    public function getById(int $id): ?ReceiptVoucher
    {
        return ReceiptVoucher::with(['source', 'journal.lines.ledger'])->find($id);
    }

    /**
     * Create a new item
     */
    public function create(array $data): ReceiptVoucher
    {
        return DB::transaction(function () use ($data) {
            $creditLedgerId = $data['credit_ledger_id'] ?? null;
            $debitLedgerId = $data['debit_ledger_id'] ?? null;
            $amount = $data['amount'] ?? 0;
            $candidateId = $data['candidate_id'] ?? null;

            unset($data['credit_ledger_id']);
            unset($data['debit_ledger_id']);
            unset($data['amount']);
            unset($data['candidate_id']);

            // Handle Source Logic using Relationship
            if ($candidateId) {
                $candidate = NewCandidate::findOrFail($candidateId);
                $receiptVoucher = $candidate->receiptVouchers()->create($data); 
            } else {
                $receiptVoucher = ReceiptVoucher::create($data);
            }

            // Create Journal Entry using morphOne relationship
            if ($creditLedgerId && $debitLedgerId && $amount > 0) {
                $lines = [
                    [
                        'ledger_id' => $debitLedgerId,
                        'debit' => $amount,
                        'credit' => 0,
                        'note' => "Receipt Voucher #{$receiptVoucher->serial_number}",
                    ],
                    [
                        'ledger_id' => $creditLedgerId,
                        'debit' => 0,
                        'credit' => $amount,
                        'note' => "Receipt Voucher #{$receiptVoucher->serial_number}",
                    ],
                ];

                // Use morphOne relationship instead of manual source_type/source_id
                $receiptVoucher->journal()->create([
                    'posting_date' => now(),
                    'status' => JournalStatus::Posted, 
                    'note' => "Generated from Receipt Voucher #{$receiptVoucher->serial_number}",
                    'total_debit' => $amount,
                    'total_credit' => $amount,
                    'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                ]);

                // Create lines through JournalHeaderService
                $journal = $receiptVoucher->journal;
                foreach ($lines as $line) {
                    $journal->lines()->create([
                        'ledger_id' => $line['ledger_id'],
                        'debit' => $line['debit'],
                        'credit' => $line['credit'],
                        'note' => $line['note'],
                        'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                    ]);
                }
            }

            return $receiptVoucher->fresh(['journal', 'source']);
        });
    }

    /**
     * Update an existing item
     */
    public function update(int $id, array $data): ?ReceiptVoucher
    {
        $item = ReceiptVoucher::find($id);

        if (!$item) {
            return null;
        }

        return DB::transaction(function () use ($item, $data) {
            $creditLedgerId = $data['credit_ledger_id'] ?? null;
            $debitLedgerId = $data['debit_ledger_id'] ?? null;
            $amount = $data['amount'] ?? 0;
            $candidateId = $data['candidate_id'] ?? null;

            unset($data['credit_ledger_id']);
            unset($data['debit_ledger_id']);
            unset($data['amount']);
            unset($data['candidate_id']);

            // Handle Source Update using morphTo relationship
            if ($candidateId) {
                $candidate = NewCandidate::findOrFail($candidateId);
                $item->source()->associate($candidate);
                $item->save();
            }
            
            $item->update($data);

            // Update Journal Entry using morphOne relationship
            if ($creditLedgerId && $debitLedgerId && $amount > 0) {
                $lines = [
                    [
                        'ledger_id' => $debitLedgerId,
                        'debit' => $amount,
                        'credit' => 0,
                        'note' => "Receipt Voucher #{$item->serial_number}",
                    ],
                    [
                        'ledger_id' => $creditLedgerId,
                        'debit' => 0,
                        'credit' => $amount,
                        'note' => "Receipt Voucher #{$item->serial_number}",
                    ],
                ];

                if ($item->journal) {
                    // Update existing journal
                    $this->journalHeaderService->updateJournal($item->journal->id, [
                        'note' => "Generated from Receipt Voucher #{$item->serial_number}",
                        'lines' => $lines,
                    ]);
                } else {
                    // Create new journal if it doesn't exist
                    $item->journal()->create([
                        'posting_date' => now(),
                        'status' => JournalStatus::Posted,
                        'note' => "Generated from Receipt Voucher #{$item->serial_number}",
                        'total_debit' => $amount,
                        'total_credit' => $amount,
                        'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                    ]);

                    $journal = $item->journal;
                    foreach ($lines as $line) {
                        $journal->lines()->create([
                            'ledger_id' => $line['ledger_id'],
                            'debit' => $line['debit'],
                            'credit' => $line['credit'],
                            'note' => $line['note'],
                            'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                        ]);
                    }
                }
            }

            return $item->fresh(['journal', 'source']);
        });
    }

    /**
     * Delete an item
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $item = ReceiptVoucher::find($id);

            if (!$item) {
                return false;
            }

            // Delete journal using morphOne relationship
            if ($item->journal) {
                $this->journalHeaderService->deleteJournal($item->journal->id);
            }

            return $item->delete();
        });
    }
}
