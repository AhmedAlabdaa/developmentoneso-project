<?php

namespace App\Services;

use App\Models\TypingTranGovInv;
use App\Queries\TypingTranGovInvQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class TypingTranGovInvService
{
    protected JournalHeaderService $journalHeaderService;

    public function __construct(JournalHeaderService $journalHeaderService)
    {
        $this->journalHeaderService = $journalHeaderService;
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
        $query = new TypingTranGovInvQuery();

        return $query
            ->withRelations()
            ->applyFilters($filters)
            ->sortBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * Get a single item by ID
     */
    public function getById(int $id): ?TypingTranGovInv
    {
        return TypingTranGovInv::with([
            'journal.lines.ledger', 
            'receiptVoucher.journal.lines.ledger',
            'ledger.crm'
        ])->find($id);
    }

    /**
     * Create a new item
     */
    public function create(array $data): TypingTranGovInv
    {
        return DB::transaction(function () use ($data) {
            $ledgerId = $data['ledger_of_account_id'];
            $services = $data['services']; // Array of services with quantities and dw
            
            unset($data['ledger_of_account_id']);
            unset($data['services']);

            // Store ledger_id on the model for reference
            $data['ledger_id'] = $ledgerId;

            $item = TypingTranGovInv::create($data);

            $totalAmount = 0;
            $journalLines = [];
            $servicesJson = []; // Build services_json array
            
            $vatLedger = \App\Models\LedgerOfAccount::where('name', 'VAT OUTPUT')->first();
            if (!$vatLedger) {
                throw new \Exception("VAT OUTPUT Ledger not found.");
            }
            $vatLedgerId = $vatLedger->id;

            // Store first service for journal reference
            $firstServiceId = null;

            // Loop through each service
            foreach ($services as $serviceData) {
                $serviceId = $serviceData['invoice_service_id'];
                $quantity = (float) $serviceData['quantity'];
                $dw = $serviceData['dw'] ?? null;

                if ($firstServiceId === null) {
                    $firstServiceId = $serviceId;
                }

                $service = \App\Models\InvoiceService::with('lines')->findOrFail($serviceId);

                // Calculate base amount (sum of credits - debits from service lines)
                $baseAmount = 0;
                foreach ($service->lines as $line) {
                    $lineCredit = (float) ($line->amount_credit ?? 0);
                    $lineDebit = (float) ($line->amount_debit ?? 0);
                    $baseAmount += ($lineCredit - $lineDebit);
                }
                $serviceTotalAmount = $baseAmount * $quantity;

                // Add to services_json with both amount and total_amount
                $servicesJson[] = [
                    'invoice_service_id' => $serviceId,
                    'quantity' => $quantity,
                    'dw' => $dw,
                    'amount' => $baseAmount,
                    'total_amount' => $serviceTotalAmount,
                ];

                foreach ($service->lines as $line) {
                    $lineDebit = (float) ($line->amount_debit ?? 0) * $quantity;
                    $lineCredit = (float) ($line->amount_credit ?? 0) * $quantity;
                    
                    // Skip lines with no amount
                    if ($lineDebit == 0 && $lineCredit == 0) {
                        continue;
                    }
                    
                    // Calculate the net amount for this line (for totalAmount calculation)
                    $netLineAmount = $lineCredit - $lineDebit;
                    $totalAmount += $netLineAmount;

                    $note =    ($serviceData['dw'] ?? '')  ."-". " (Qty: {$quantity})" . "-" . ($item->serial_no ?? '') .  "-" . ($line->note ?? '');

                    if ($lineCredit > 0) {
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'debit' => 0,
                            'credit' => $lineCredit,
                            'note' => $note,
                        ];
                    } elseif ($lineDebit > 0) {
                        $journalLines[] = [
                            'ledger_id' => $line->ledger_account_id,
                            'debit' => $lineDebit,
                            'credit' => 0,
                            'note' => $note,
                        ];
                    }
                }
            }

            // Debit Customer Account (Total)
            array_unshift($journalLines, [
                'ledger_id' => $ledgerId,
                'debit' => $totalAmount,
                'credit' => 0,
                'note' => "Invoice: {$item->serial_no}",
            ]);

            // Create Journal Header via Service
            $journal = $this->journalHeaderService->createJournal([
                'posting_date' => now(),
                'status' => 1, 
                'note' => "Generated from TypingTranGovInv #{$item->serial_no}",
                'source_type' => $item->getMorphClass(),
                'source_id' => $item->getKey(),
                'pre_src_type' => \App\Models\InvoiceService::class,
                'pre_src_id' => $firstServiceId,
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? null,
                'lines' => $journalLines,
            ]);

            // Sync amount_of_invoice and services_json - use totalAmount (customer charge)
            $item->update([
                'amount_of_invoice' => $totalAmount,
                'services_json' => $servicesJson,
            ]);

            return $item;
        });
    }

    /**
     * Update an existing item
     */
    public function update(int $id, array $data): ?TypingTranGovInv
    {
        $item = TypingTranGovInv::find($id);

        if (!$item) {
            return null;
        }

        return DB::transaction(function () use ($item, $data) {
            // Extract IDs or null if not present
            $ledgerId = $data['ledger_of_account_id'] ?? null;
            $services = $data['services'] ?? null;

            // Remove non-model attributes
            unset($data['ledger_of_account_id']);
            unset($data['services']);

            // IMPORTANT: Always remove amount_received from update data
            // amount_received should ONLY be managed by the receivePayment method
            // This prevents accidental resets to zero when updating other fields
            unset($data['amount_received']);

            // Update ledger_id on the model if provided
            if ($ledgerId) {
                $data['ledger_id'] = $ledgerId;
            }

            // Update the main record
            $item->update($data);

            $journal = $item->journal;

            if ($journal && $services) {
                // Effective Ledger ID
                if ($ledgerId) {
                    $effectiveLedgerId = $ledgerId;
                } else {
                    // Fallback: Try to find the Customer Debit line
                    $firstLine = $journal->lines()->orderBy('id')->first();
                    $effectiveLedgerId = $firstLine ? $firstLine->ledger_id : null;
                }

                if ($effectiveLedgerId) {
                    // Regenerate Journal Lines based on services array
                    $totalAmount = 0;
                    $journalLines = [];
                    $servicesJson = []; // Build services_json array
                    
                    $vatLedger = \App\Models\LedgerOfAccount::where('name', 'VAT OUTPUT')->first();
                    $vatLedgerId = $vatLedger ? $vatLedger->id : 32;

                    $firstServiceId = null;

                    // Loop through each service
                    foreach ($services as $serviceData) {
                        $serviceId = $serviceData['invoice_service_id'];
                        $quantity = (float) $serviceData['quantity'];
                        $dw = $serviceData['dw'] ?? null;

                        if ($firstServiceId === null) {
                            $firstServiceId = $serviceId;
                        }

                        $service = \App\Models\InvoiceService::with('lines')->find($serviceId);
                        
                        if ($service) {
                            // Calculate base amount (sum of credits - debits from service lines)
                            $baseAmount = 0;
                            foreach ($service->lines as $line) {
                                $lineCredit = (float) ($line->amount_credit ?? 0);
                                $lineDebit = (float) ($line->amount_debit ?? 0);
                                $baseAmount += ($lineCredit - $lineDebit);
                            }
                            $serviceTotalAmount = $baseAmount * $quantity;

                            // Add to services_json with both amount and total_amount
                            $servicesJson[] = [
                                'invoice_service_id' => $serviceId,
                                'quantity' => $quantity,
                                'dw' => $dw,
                                'amount' => $baseAmount,
                                'total_amount' => $serviceTotalAmount,
                            ];

                            foreach ($service->lines as $line) {
                                $lineDebit = (float) ($line->amount_debit ?? 0) * $quantity;
                                $lineCredit = (float) ($line->amount_credit ?? 0) * $quantity;
                                
                                // Skip lines with no amount
                                if ($lineDebit == 0 && $lineCredit == 0) {
                                    continue;
                                }
                                
                                // Calculate the net amount for this line
                                $netLineAmount = $lineCredit - $lineDebit;
                                $totalAmount += $netLineAmount;

                                $note = ($serviceData['dw'] ?? '') . "-" . " (Qty: {$quantity})" . "-" . ($item->serial_no ?? '') . "-" . ($line->note ?? '');

                                if ($lineCredit > 0) {
                                    $journalLines[] = [
                                        'ledger_id' => $line->ledger_account_id,
                                        'debit' => 0,
                                        'credit' => $lineCredit,
                                        'note' => $note,
                                    ];
                                } elseif ($lineDebit > 0) {
                                    $journalLines[] = [
                                        'ledger_id' => $line->ledger_account_id,
                                        'debit' => $lineDebit,
                                        'credit' => 0,
                                        'note' => $note,
                                    ];
                                }
                            }
                        }
                    }

                    // Debit Customer
                    array_unshift($journalLines, [
                        'ledger_id' => $effectiveLedgerId,
                        'debit' => $totalAmount,
                        'credit' => 0,
                        'note' => "Invoice: {$item->serial_no}",
                    ]);

                    // Update Journal Bundle
                    $updatedJournal = $this->journalHeaderService->updateJournal($journal->id, [
                        'pre_src_type' => \App\Models\InvoiceService::class,
                        'pre_src_id' => $firstServiceId,
                        'total_debit' => $totalAmount,
                        'total_credit' => $totalAmount,
                        'lines' => $journalLines
                    ]);

                    // Sync amount_of_invoice and services_json - use totalAmount (customer charge)
                    if ($updatedJournal) {
                        $item->update([
                            'amount_of_invoice' => $totalAmount,
                            'services_json' => $servicesJson,
                        ]);
                    }
                }
            }

            return $item->fresh(['journal']);
        });
    }

    /**
     * Delete an item
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $item = TypingTranGovInv::with('journal')->find($id);

            if (!$item) {
                return false;
            }

            // Delete associated Journal Entry if exists
            if ($item->journal) {
                $this->journalHeaderService->deleteJournal($item->journal->id);
            }

            return $item->delete();
        });
    }

    /**
     * Receive payment for a typing invoice
     * 
     * Creates a ReceiptVoucher linked to the typing invoice with proper journal entry
     */
    public function receivePayment(int $id, array $data): ?\App\Models\ReceiptVoucher
    {
        return DB::transaction(function () use ($id, $data) {
            $typingInvoice = TypingTranGovInv::find($id);

            if (!$typingInvoice) {
                return null;
            }

            $creditLedgerId = $data['credit_ledger_id'];
            $debitLedgerId = $data['debit_ledger_id'];
            $amount = $data['amount'];

            // Remove ledger and amount from data since they're not part of ReceiptVoucher model
            unset($data['credit_ledger_id']);
            unset($data['debit_ledger_id']);
            unset($data['amount']);

            // Create Receipt Voucher using polymorphic relationship
            $receiptVoucher = $typingInvoice->receiptVoucher()->create($data);

            // Create Journal Entry for the payment
            if ($creditLedgerId && $debitLedgerId && $amount > 0) {
                $lines = [
                    [
                        'ledger_id' => $debitLedgerId,
                        'debit' => $amount,
                        'credit' => 0,
                        'note' => "Payment for Invoice #{$typingInvoice->serial_no} via {$receiptVoucher->serial_number}",
                    ],
                    [
                        'ledger_id' => $creditLedgerId,
                        'debit' => 0,
                        'credit' => $amount,
                        'note' => "Payment for Invoice #{$typingInvoice->serial_no} via {$receiptVoucher->serial_number}",
                    ],
                ];

                // Create journal header using morphOne relationship
                $receiptVoucher->journal()->create([
                    'posting_date' => now(),
                    'status' => \App\Enum\JournalStatus::Posted,
                    'note' => "Receipt for Typing Invoice #{$typingInvoice->serial_no}",
                    'total_debit' => $amount,
                    'total_credit' => $amount,
                    'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                ]);

                // Create journal lines
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

            // Update amount_received on the typing invoice
            $currentReceived = $typingInvoice->amount_received ?? 0;
            $typingInvoice->update(['amount_received' => $currentReceived + $amount]);

            return $receiptVoucher->fresh(['journal.lines', 'source']);
        });
    }
}
