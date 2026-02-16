<?php

namespace App\Services;

use App\Models\CRM;
use App\Models\Invoice;
use App\Models\InvoiceService;
use App\Models\JournalHeader;
use App\Models\Package;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PackageOneService
{
    protected JournalHeaderService $journalHeaderService;
    protected ReceiptVoucherService $receiptVoucherService;

    public function __construct(
        JournalHeaderService $journalHeaderService,
        ReceiptVoucherService $receiptVoucherService
    ) {
        $this->journalHeaderService = $journalHeaderService;
        $this->receiptVoucherService = $receiptVoucherService;
    }

    /**
     * Create journal entries for PackageOne (financial impact only)
     * Links to existing invoice via source_id and updates has_finance flag
     * 
     * @param array $data Contains invoice_id, cn_number, customer_id, invoice_service_id (optional)
     * @return JournalHeader
     */
    public function create(array $data): JournalHeader
    {
        return DB::transaction(function () use ($data) {
            $invoiceId = $data['invoice_id'];
            $cnNumber = $data['cn_number'];
            $customerId = $data['customer_id'];
            $invoiceServiceId = $data['invoice_service_id'] ?? null;

            // Find customer from CRM and get ledger ID
            $customer = CRM::findOrFail($customerId);
            if (!$customer->ledger_id) {
                throw new \Exception("Customer does not have an associated ledger account.");
            }
            $ledgerId = $customer->ledger_id;

            // Find the invoice
            $invoice = Invoice::findOrFail($invoiceId);

            // If no specific service provided, get first active service of type=1 (Package One)
            if (!$invoiceServiceId) {
                $invoiceService = InvoiceService::where('type', 2)
                    ->where('status', 1)
                    ->with('lines')
                    ->first();
                
                if (!$invoiceService) {
                    throw new \Exception("No active Package One service found.");
                }
            } else {
                $invoiceService = InvoiceService::with('lines')->findOrFail($invoiceServiceId);
            }

            // Calculate total amount from service lines
            $totalAmount = 0;
            $journalLines = [];

            $vatLedger = \App\Models\LedgerOfAccount::where('name', 'VAT')->first();
            if (!$vatLedger) {
                throw new \Exception("VAT Ledger not found.");
            }
            $vatLedgerId = $vatLedger->id;

            foreach ($invoiceService->lines as $line) {
                $lineDebit = (float) ($line->amount_debit ?? 0);
                $lineCredit = (float) ($line->amount_credit ?? 0);
                
                // Skip lines with no amount
                if ($lineDebit == 0 && $lineCredit == 0) {
                    continue;
                }
                
                // Calculate the net amount for this line (for totalAmount calculation)
                $netLineAmount = $lineCredit - $lineDebit;
                $totalAmount += $netLineAmount;

                if ($line->vatable) {
                    // Inclusive VAT Calculation (5%)
                    if ($lineCredit > 0) {
                        $netAmount = round($lineCredit / 1.05, 2);
                        $vatAmount = round($lineCredit - $netAmount, 2);

                        // Credit Service Account (Net)
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'cn_number' => $cnNumber,
                            'debit' => 0,
                            'credit' => $netAmount,
                            'note' => $line->note ?? 'Service Revenue (Net)',
                        ];

                        // Credit VAT Account
                        $journalLines[] = [
                            'ledger_id' => $vatLedgerId,
                            'cn_number' => $cnNumber,
                            'debit' => 0,
                            'credit' => $vatAmount,
                            'note' => 'VAT 5%',
                        ];
                    } elseif ($lineDebit > 0) {
                        $netAmount = round($lineDebit / 1.05, 2);
                        $vatAmount = round($lineDebit - $netAmount, 2);

                        // Debit Service Account (Net) - expense/reduction
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'cn_number' => $cnNumber,
                            'debit' => $netAmount,
                            'credit' => 0,
                            'note' => $line->note ?? 'Service Expense (Net)',
                        ];

                        // Debit VAT Account
                        $journalLines[] = [
                            'ledger_id' => $vatLedgerId,
                            'cn_number' => $cnNumber,
                            'debit' => $vatAmount,
                            'credit' => 0,
                            'note' => 'VAT 5%',
                        ];
                    }
                } else {
                    // Non-vatable: create debit or credit line based on which has value
                    if ($lineCredit > 0) {
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'cn_number' => $cnNumber,
                            'debit' => 0,
                            'credit' => $lineCredit,
                            'note' => $line->note ?? 'Service Revenue',
                        ];
                    } elseif ($lineDebit > 0) {
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'cn_number' => $cnNumber,
                            'debit' => $lineDebit,
                            'credit' => 0,
                            'note' => $line->note ?? 'Service Expense',
                        ];
                    }
                }
            }

            // Debit Customer Account (Total)
            array_unshift($journalLines, [
                'ledger_id' => $ledgerId,
                'cn_number' => $cnNumber,
                'debit' => $totalAmount,
                'credit' => 0,
                'note' => "Package One - CN: {$cnNumber}",
            ]);

            // Create Journal Header via Service with invoice as source
            $journal = $this->journalHeaderService->createJournal([
                'posting_date' => now(),
                'status' => 1,
                'note' => "Package One financial entry for CN: {$cnNumber}",
                'source_type' => Invoice::class,
                'source_id' => $invoice->getKey(),
                'pre_src_type' => InvoiceService::class,
                'pre_src_id' => $invoiceService->id,
                'created_by' => Auth::id() ?? null,
                'lines' => $journalLines,
            ]);

            // Update invoice has_finance to true
            $invoice->update(['has_finance' => true]);

            // Create Receipt Voucher if amount_received > 0
            $amountReceived = $data['amount_received'] ?? 0;
            if ($amountReceived > 0) {
                $debitLedgerId = $data['debit_ledger_id'];
                
                $receiptVoucher = $this->receiptVoucherService->create([
                    'serial_number' => 'RV-' . $cnNumber,
                    'credit_ledger_id' => $ledgerId, 
                    'debit_ledger_id' => $debitLedgerId, 
                    'amount' => $amountReceived,
                    'note' => "Receipt for Package One - CN: {$cnNumber}",
                ]);

                // Set the Invoice as source for the receipt voucher
                $receiptVoucher->source()->associate($invoice);
                $receiptVoucher->save();
            }

            return $journal;
        });
    }

    /**
     * Get journal by ID with lines
     */
    public function getById(int $id): ?JournalHeader
    {
        return JournalHeader::with(['lines.ledger', 'preSrc', 'source'])->find($id);
    }

    /**
     * List journals with Package One filtering (by cn_number in lines)
     */
    public function getPaginated(
        array $filters = [],
        int $perPage = 15,
        string $sortBy = 'id',
        string $sortDirection = 'desc'
    ) {
        $query = JournalHeader::query()
            ->where('source_type', Invoice::class)
            ->with(['lines.ledger', 'preSrc', 'source']);

        if (!empty($filters['cn_number'])) {
            $cnNumber = $filters['cn_number'];
            $query->whereHas('lines', function ($q) use ($cnNumber) {
                $q->where('cn_number', 'like', "%{$cnNumber}%");
            });
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('note', 'like', "%{$search}%")
                  ->orWhereHas('lines', function ($q2) use ($search) {
                      $q2->where('cn_number', 'like', "%{$search}%");
                  });
            });
        }

        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    /**
     * Delete a PackageOne journal entry and reset has_finance on invoice
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $journal = JournalHeader::find($id);
            
            if (!$journal) {
                return false;
            }

            // Reset has_finance on the invoice if it exists
            if ($journal->source_type === Invoice::class && $journal->source_id) {
                $invoice = Invoice::find($journal->source_id);
                if ($invoice) {
                    $invoice->update(['has_finance' => false]);
                }
            }

            return $this->journalHeaderService->deleteJournal($id);
        });
    }

    /**
     * Create a Receipt Voucher for PackageOne
     * 
     * @param array $data Contains debit_ledger_id, customer_id, invoice_id, amount, method_mode, note
     * @return \App\Models\ReceiptVoucher
     */
    public function receivedVoucher(array $data)
    {
        return DB::transaction(function () use ($data) {
            $debitLedgerId = $data['debit_ledger_id'];
            $customerId = $data['customer_id'];
            $invoiceId = $data['invoice_id'];
            $amount = $data['amount'] ?? 0;
            $methodMode = $data['method_mode'] ?? null;
            $note = $data['note'] ?? null;

            // Find customer from CRM and get ledger ID (credit side)
            $customer = CRM::findOrFail($customerId);
            if (!$customer->ledger_id) {
                throw new \Exception("Customer does not have an associated ledger account.");
            }
            $creditLedgerId = $customer->ledger_id;

            // Find the invoice for the source relationship
            $invoice = Invoice::findOrFail($invoiceId);

            // Log::info('Invoice found: ' . $invoice);

            // Generate serial number
            $serialNumber = 'RV-PKG-' . now()->format('YmdHis');

            // Create Receipt Voucher via ReceiptVoucherService
            $receiptVoucher = $this->receiptVoucherService->create([
                'serial_number' => $serialNumber,
                'credit_ledger_id' => $creditLedgerId,
                'debit_ledger_id' => $debitLedgerId,
                'amount' => $amount,
                'payment_mode' => $methodMode,
                'note' => $note ?? "Receipt for Package One",
            ]);

            // Set the Invoice as source for the receipt voucher
            $receiptVoucher->source()->associate($invoice);
            $invoice->has_finance = 1;

            $invoice->save();
            $receiptVoucher->save();

            return $receiptVoucher->fresh(['journal', 'source']);
        });
    }

    /**
     * Create a Credit Note (reverse journal entries) for PackageOne
     * 
     * @param array $data Contains invoice_id
     * @return JournalHeader
     */
    public function creditNote(array $data): JournalHeader
    {
        return DB::transaction(function () use ($data) {
            $invoiceId = $data['invoice_id'];

            // Find the invoice
            $invoice = Invoice::findOrFail($invoiceId);

            // Check if invoice is already refunded
            if ($invoice->refunded) {
                throw new \Exception("This invoice has already been refunded.");
            }

            // Find the original journal entry for this invoice
            $originalJournal = JournalHeader::where('source_type', Invoice::class)
                ->where('source_id', $invoice->getKey())
                ->with('lines')
                ->first();

            if (!$originalJournal) {
                throw new \Exception("No journal entry found for this invoice.");
            }

            // Create reversed journal lines (swap debit and credit)
            $reversedLines = [];
            foreach ($originalJournal->lines as $line) {
                $reversedLines[] = [
                    'ledger_id' => $line->ledger_id,
                    'cn_number' => $line->cn_number,
                    'debit' => $line->credit,  // Swap: original credit becomes debit
                    'credit' => $line->debit,  // Swap: original debit becomes credit
                    'note' => 'Credit Note - ' . ($line->note ?? ''),
                ];
            }

            // Create the reversed Journal Header
            $creditNoteJournal = $this->journalHeaderService->createJournal([
                'posting_date' => now(),
                'status' => 1,
                'note' => "Credit Note for Invoice #{$invoice->invoice_number}",
                'source_type' => Invoice::class,
                'source_id' => $invoice->getKey(),
                'created_by' => Auth::id() ?? null,
                'lines' => $reversedLines,
            ]);

            // Mark the invoice as refunded
            $invoice->update(['refunded' => true]);

            return $creditNoteJournal;
        });
    }

    /**
     * Create a Charging journal entry for PackageOne
     * 
     * @param array $data Contains invoice_id, customer_id, note (optional), lines (array of ledger_id, amount for credit)
     * @return JournalHeader
     */
    public function charging(array $data): JournalHeader
    {
        return DB::transaction(function () use ($data) {
            $invoiceId = $data['invoice_id'];
            $customerId = $data['customer_id'];
            $note = $data['note'] ?? null;
            $lines = $data['lines'];

            // Find customer from CRM and get ledger ID for debit
            $customer = CRM::findOrFail($customerId);
            if (!$customer->ledger_id) {
                throw new \Exception("Customer does not have an associated ledger account.");
            }
            $debitLedgerId = $customer->ledger_id;

            // Find the invoice
            $invoice = Invoice::findOrFail($invoiceId);

            // Prepare credit journal lines and calculate total
            $journalLines = [];
            $totalAmount = 0;

            foreach ($lines as $line) {
                $amount = (float) ($line['amount'] ?? 0);
                $totalAmount += $amount;

                $journalLines[] = [
                    'ledger_id' => $line['ledger_id'],
                    'debit' => 0,
                    'credit' => $amount,
                    'note' => $line['note'] ?? $note ?? 'Charging entry',
                ];
            }

            // Add debit entry for customer (total amount)
            array_unshift($journalLines, [
                'ledger_id' => $debitLedgerId,
                'debit' => $totalAmount,
                'credit' => 0,
                'note' => $note ?? "Charging for Invoice #{$invoice->invoice_number}",
            ]);

            // Create Journal Header via Service with invoice as source
            $journal = $this->journalHeaderService->createJournal([
                'posting_date' => now(),
                'status' => 1,
                'note' => $note ?? "Charging for Invoice #{$invoice->invoice_number}",
                'source_type' => Invoice::class,
                'source_id' => $invoice->getKey(),
                'created_by' => Auth::id() ?? null,
                'lines' => $journalLines,
            ]);

            return $journal;
        });
    }
}



