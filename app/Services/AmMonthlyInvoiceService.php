<?php

namespace App\Services;

use App\Enum\Spacial;
use App\Models\AmInstallment;
use App\Models\AmMonthlyContractInv;
use App\Models\LedgerOfAccount;
use App\Services\JournalHeaderService;
use Illuminate\Support\Facades\DB;
use Exception;

class AmMonthlyInvoiceService
{
    protected JournalHeaderService $journalService;

    public function __construct(JournalHeaderService $journalService)
    {
        $this->journalService = $journalService;
    }

    /**
     * Create a new monthly invoice from an installment.
     *
     * Handles ledger resolution, VAT/salary/profit calculations,
     * invoice creation, installment status update, and journal entry creation.
     *
     * @param array $data Validated request data (installment_id)
     * @return AmMonthlyContractInv
     * @throws Exception
     */
    public function createInvoice(array $data): AmMonthlyContractInv
    {
        $installment = AmInstallment::findOrFail($data['installment_id']);

        if ($installment->status == 1) {
            throw new Exception('Installment already invoiced');
        }

        return DB::transaction(function () use ($data, $installment) {
            // 1. Data Retrieval
            $contractMovment = $installment->contractMovment;
            $primaryContract = $contractMovment->primaryContract;
            $crm = $primaryContract->crm;
            $employee = $contractMovment->employee;

            // 2. Ledger Resolution
            $customerLedgerId = $crm->ledger_id;
            $vatLedgerId = $this->resolveLedger('VAT Output', 'name', '%VAT OUTPUT%');
            $maidSalaryLedgerId = $this->resolveLedger('Maid Salary', 'spacial', Spacial::maidSalary);
            $p3ProfitLedgerId = $this->resolveLedger('P3 Profit', 'spacial', Spacial::p3Profit);

            $monthlySalary = $employee->salary ?? 0;
            $salaryCost = $monthlySalary;

            // 3. Calculations
            $totalAmount = $installment->amount;
            $baseAmount = $totalAmount / 1.05;
            $vatAmount = ($totalAmount - $salaryCost)/ 1.05 * 0.05; 

            
            // Validate: invoice base amount must cover salary cost
            if ($baseAmount < $salaryCost) {
                throw new \Illuminate\Validation\ValidationException(
                    validator([], []),
                    response()->json([
                        'message' => 'Invoice amount is less than maid salary.',
                        'errors' => [
                            'amount' => [
                                "Invoice base amount (" . round($baseAmount, 2) . ") is less than maid salary cost (" . round($salaryCost, 2) . ")."
                            ]
                        ]
                    ], 422)
                );
            }

            $profitAmount = $totalAmount - $vatAmount - $salaryCost;

            // 4. Create Invoice Record
            $invoice = AmMonthlyContractInv::create([
                'date' => $installment->date,
                'am_monthly_contract_id' => $contractMovment->id,
                'crm_id' => $crm->id,
                'am_installment_id' => $installment->id,
                'note' => $installment->note,
                'amount' => $totalAmount,
                'paid_amount' => 0,
            ]);

            // 5. Update Installment Status
            $installment->update(['status' => 1]);

            // 6. Create Journal Entry
            $this->journalService->createJournal([
                'posting_date' => $installment->date ,
                'note' => "Invoice for Installment #{$installment->id}",
                'source_type' => AmMonthlyContractInv::class,
                'source_id' => $invoice->id,
                'status' => \App\Enum\JournalStatus::Draft,
                'lines' => [
                    [
                        'ledger_id' => $customerLedgerId,
                        'debit' => $totalAmount,
                        'credit' => 0,
                        'note' => "Invoice #{$invoice->serial_no} - Customer Charge",
                    ],
                    [
                        'ledger_id' => $vatLedgerId,
                        'debit' => 0,
                        'credit' => $vatAmount,
                        'note' => " Invoice #{$invoice->serial_no} VAT Output (5%)",
                    ],
                    [
                        'ledger_id' => $maidSalaryLedgerId,
                        'debit' => 0,
                        'credit' => $salaryCost,
                        'note' => " #{$installment?->employee?->name} - Maid Salary",
                    ],
                    [
                        'ledger_id' => $p3ProfitLedgerId,
                        'debit' => 0,
                        'credit' => $profitAmount,
                        'note' => "P3 Profit",
                    ],
                ],
            ]);

            return $invoice->fresh(['contractMovment.employee', 'crm', 'installment', 'journal.lines']);
        });
    }

    /**
     * Update an existing monthly invoice.
     *
     * @param AmMonthlyContractInv $invoice
     * @param array $data
     * @return AmMonthlyContractInv
     * @throws Exception
     */
    public function updateInvoice(AmMonthlyContractInv $invoice, array $data): AmMonthlyContractInv
    {
        return DB::transaction(function () use ($invoice, $data) {
            $invoice->update([
                'date' => $data['date'] ?? $invoice->date,
                'note' => $data['note'] ?? $invoice->note,
                'amount' => $data['amount'] ?? $invoice->amount,
                'paid_amount' => $data['paid_amount'] ?? $invoice->paid_amount,
            ]);

            return $invoice->fresh(['contractMovment.employee', 'crm', 'installment', 'journal.lines']);
        });
    }

    /**
     * Delete a monthly invoice.
     *
     * Reverts the installment status to 0 (pending) and deletes
     * the associated journal entry.
     *
     * @param AmMonthlyContractInv $invoice
     * @return bool
     * @throws Exception
     */
    public function deleteInvoice(AmMonthlyContractInv $invoice): bool
    {
        return DB::transaction(function () use ($invoice) {
            // Revert installment status
            if ($invoice->installment) {
                $invoice->installment->update(['status' => 0]);
            }

            // Delete associated journal
            $journal = $invoice->journal;
            if ($journal) {
                $this->journalService->deleteJournal($journal->id);
            }

            return $invoice->delete();
        });
    }

    /**
     * Receive payment for a monthly invoice.
     *
     * Creates a receipt voucher linked to the invoice with a journal entry
     * (Debit: payment ledger, Credit: customer ledger) and updates paid_amount.
     *
     * @param AmMonthlyContractInv $invoice
     * @param array $data (amount, debit_ledger_id, note?, payment_mode?)
     * @return AmMonthlyContractInv
     * @throws Exception
     */
    public function receivePayment(AmMonthlyContractInv $invoice, array $data): AmMonthlyContractInv
    {
        $amount = $data['amount'];
        $remaining = $invoice->amount - $invoice->paid_amount;

        if ($amount <= 0) {
            throw new Exception('Payment amount must be greater than 0');
        }

        if ($amount > $remaining) {
            throw new Exception("Payment amount ({$amount}) exceeds remaining balance ({$remaining})");
        }

        return DB::transaction(function () use ($invoice, $data, $amount) {
            // Resolve customer ledger from invoice
            $crm = $invoice->crm ?? $invoice->contractMovment?->primaryContract?->crm;
            $customerLedgerId = $crm->ledger_id;
            $debitLedgerId = $data['debit_ledger_id']; // Cash or Bank ledger

            // Create Receipt Voucher linked to invoice via morph
            $receiptVoucher = new \App\Models\ReceiptVoucher();
            $receiptVoucher->source_type = AmMonthlyContractInv::class;
            $receiptVoucher->source_id = $invoice->id;
            $receiptVoucher->status = 1;
            $receiptVoucher->payment_mode = $data['payment_mode'] ?? 1;
            $receiptVoucher->save();

            // Create journal entry for the payment
            $receiptVoucher->journal()->create([
                'posting_date' => now()->toDateString(),
                'status' => \App\Enum\JournalStatus::Posted,
                'note' => "Payment for Invoice #{$invoice->serial_no}",
                'total_debit' => $amount,
                'total_credit' => $amount,
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);

            $journal = $receiptVoucher->journal;
            $journal->lines()->create([
                'ledger_id' => $debitLedgerId,
                'debit' => $amount,
                'credit' => 0,
                'note' => "Payment received - Invoice #{$invoice->serial_no}",
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);
            $journal->lines()->create([
                'ledger_id' => $customerLedgerId,
                'debit' => 0,
                'credit' => $amount,
                'note' => "Payment received - Invoice #{$invoice->serial_no}",
                'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
            ]);

            // Update invoice paid amount
            $invoice->update([
                'paid_amount' => $invoice->paid_amount + $amount,
            ]);

            return $invoice->fresh(['contractMovment.employee', 'crm', 'installment', 'journal.lines']);
        });
    }

    /**
     * Issue a credit note for a monthly invoice.
     *
     * Full credit: reverses the entire invoice journal (swap debit/credit).
     * Partial credit: recalculates based on days and reverses the difference.
     *
     * @param AmMonthlyContractInv $invoice
     * @param array $data (credit_type: full|partial, days?: int for partial)
     * @return AmMonthlyContractInv
     * @throws Exception
     */
    public function creditNote(AmMonthlyContractInv $invoice, array $data): AmMonthlyContractInv
    {
        $originalJournal = $invoice->journal;
        if (!$originalJournal) {
            throw new Exception('Invoice has no journal entry to reverse');
        }

        $originalJournal->load('lines');

        return DB::transaction(function () use ($invoice, $data, $originalJournal) {
            $creditType = $data['credit_type']; // 'full' or 'partial'
            $invoiceAmount = round((float) $invoice->amount, 2);
            $currentRefundedAmount = round((float) ($invoice->refunded_amount ?? 0), 2);
            $creditAmount = 0.0;

            if ($creditType === 'full') {
                // Full credit: reverse all lines
                $reversalLines = [];
                foreach ($originalJournal->lines as $line) {
                    $reversalLines[] = [
                        'ledger_id' => $line->ledger_id,
                        'debit' => $line->credit,   // swap
                        'credit' => $line->debit,    // swap
                        'note' => "Credit Note (Full) - Reversal of {$line->note}",
                    ];
                }

                $creditAmount = round((float) $originalJournal->total_debit, 2);

                $this->journalService->createJournal([
                    'posting_date' => now()->toDateString(),
                    'note' => "Credit Note (Full) - Reversal of Invoice #{$invoice->serial_no}",
                    'source_type' => AmMonthlyContractInv::class,
                    'source_id' => $invoice->id,
                    'pre_src_type' => get_class($originalJournal),
                    'pre_src_id' => $originalJournal->id,
                    'status' => \App\Enum\JournalStatus::Draft,
                    'lines' => $reversalLines,
                ]);

                $newRefundedAmount = round($currentRefundedAmount + $creditAmount, 2);
                if ($newRefundedAmount > $invoiceAmount) {
                    throw new Exception("Refunded amount ({$newRefundedAmount}) exceeds invoice amount ({$invoiceAmount})");
                }

                // Append credit note remark
                $invoice->update([
                    'refunded_amount' => $newRefundedAmount,
                    'note' => ($invoice->note ? $invoice->note . ' | ' : '') . 'CREDIT NOTE (Full)',
                ]);

            } else {
                // Partial credit by days
                $days = $data['days'];
                $contractMovment = $invoice->contractMovment;
                $employee = $contractMovment->employee;
                $crm = $contractMovment->primaryContract->crm;

                $originalTotal = $invoice->amount;
                $originalBase = $originalTotal / 1.05;
                $originalVat = $originalTotal - $originalBase;

                $monthlySalary = $employee->salary ?? 0;

                // New amounts based on partial days
                $newSalaryCost = ($monthlySalary / 30) * $days;
                $newBase = $newSalaryCost; // minimum base is the salary
                $newTotal = $newBase * 1.05;
                $newVat = $newTotal - $newBase;
                $newProfit = $newBase - $newSalaryCost; // will be 0 for minimum

                // If we need to retain more (e.g. proportional profit)
                // Use proportional: newTotal = originalTotal * (days / 30)
                $newTotal = round($originalTotal * ($days / 30), 2);
                $newBase = $newTotal / 1.05;
                $newVat = $newTotal - $newBase;
                $newSalaryCost = ($monthlySalary / 30) * $days;
                $newProfit = $newBase - $newSalaryCost;

                // Credit difference
                $diffTotal = $originalTotal - $newTotal;
                $diffBase = $originalBase - $newBase;
                $diffVat = $originalVat - $newVat;

                $originalSalaryCost = $monthlySalary; // was monthly
                $diffSalary = $originalSalaryCost - $newSalaryCost;
                $diffProfit = $diffBase - $diffSalary;

                // Resolve ledgers
                $customerLedgerId = $crm->ledger_id;
                $vatLedgerId = $this->resolveLedger('VAT Output', 'name', '%VAT OUTPUT%');
                $maidSalaryLedgerId = $this->resolveLedger('Maid Salary', 'spacial', Spacial::maidSalary);
                $p3ProfitLedgerId = $this->resolveLedger('P3 Profit', 'spacial', Spacial::p3Profit);

                // Reversal lines (reverse the difference)
                $reversalLines = [
                    [
                        'ledger_id' => $customerLedgerId,
                        'debit' => 0,
                        'credit' => round($diffTotal, 2),
                        'note' => "Credit Note (Partial {$days} days) - Customer",
                    ],
                    [
                        'ledger_id' => $vatLedgerId,
                        'debit' => round($diffVat, 2),
                        'credit' => 0,
                        'note' => "Credit Note (Partial {$days} days) - VAT Reversal",
                    ],
                    [
                        'ledger_id' => $maidSalaryLedgerId,
                        'debit' => round($diffSalary, 2),
                        'credit' => 0,
                        'note' => "Credit Note (Partial {$days} days) - Salary Reversal",
                    ],
                    [
                        'ledger_id' => $p3ProfitLedgerId,
                        'debit' => round($diffProfit, 2),
                        'credit' => 0,
                        'note' => "Credit Note (Partial {$days} days) - Profit Reversal",
                    ],
                ];

                $creditAmount = round($diffTotal, 2);
                if ($creditAmount <= 0) {
                    throw new Exception('Credit note amount must be greater than 0');
                }

                $newRefundedAmount = round($currentRefundedAmount + $creditAmount, 2);
                if ($newRefundedAmount > $invoiceAmount) {
                    throw new Exception("Refunded amount ({$newRefundedAmount}) exceeds invoice amount ({$invoiceAmount})");
                }

                $this->journalService->createJournal([
                    'posting_date' => now()->toDateString(),
                    'note' => "Credit Note (Partial {$days} days) - Invoice #{$invoice->serial_no}",
                    'source_type' => AmMonthlyContractInv::class,
                    'source_id' => $invoice->id,
                    'pre_src_type' => get_class($originalJournal),
                    'pre_src_id' => $originalJournal->id,
                    'status' => \App\Enum\JournalStatus::Draft,
                    'lines' => $reversalLines,
                ]);

                // Append credit note remark
                $invoice->update([
                    'refunded_amount' => $newRefundedAmount,
                    'note' => ($invoice->note ? $invoice->note . ' | ' : '') . "CREDIT NOTE (Partial {$days} days)",
                ]);
            }

            return $invoice->fresh(['contractMovment.employee', 'crm', 'installment', 'journal.lines']);
        });
    }

    /**
     * Resolve a ledger account by name (LIKE) or spacial enum.
     *
     * @param string $label Human-readable label for error messages
     * @param string $field 'name' or 'spacial'
     * @param mixed $value
     * @return int Ledger ID
     * @throws Exception
     */
    protected function resolveLedger(string $label, string $field, $value): int
    {
        if ($field === 'name') {
            $ledger = LedgerOfAccount::where('name', 'like', $value)->first()
                ?? LedgerOfAccount::where('name', 'VAT Output')->first();
        } else {
            $ledger = LedgerOfAccount::where($field, $value)->first();
        }

        if (!$ledger) {
            throw new Exception("{$label} Ledger not found");
        }

        return $ledger->id;
    }
}
