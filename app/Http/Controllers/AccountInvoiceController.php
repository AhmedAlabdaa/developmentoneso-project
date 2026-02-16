<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\JournalEntries;
use App\Models\JournalEntryDetails;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountInvoiceController extends Controller
{
    protected function notify(array $data): void
    {
        Notification::create($data);
    }

    public function createPendingInvoice(Request $r, string $filePath): Invoice
    {
        return DB::transaction(function () use ($r, $filePath) {
            $agreement = Agreement::where('candidate_id', $r->input('candidate_id'))
                ->where('client_id', $r->input('client_id'))
                ->lockForUpdate()
                ->firstOrFail();

            $pro = Invoice::where('agreement_reference_no', $agreement->reference_no)
                ->where('invoice_type', 'Proforma')
                ->latest('invoice_id')
                ->first();

            $totalAmount = $pro ? (float) $pro->total_amount : (float) $r->input('remaining_amount', 0);
            $payment     = (float) $r->input('received_amount', 0);

            $taxInvoice = Invoice::where('agreement_reference_no', $agreement->reference_no)
                ->where('invoice_type', 'Tax')
                ->lockForUpdate()
                ->first();

            if ($taxInvoice) {
                $newReceived = min($taxInvoice->received_amount + $payment, $totalAmount);
                $newBalance  = max($totalAmount - $newReceived, 0);

                $taxInvoice->update([
                    'payment_method'  => $r->input('payment_method'),
                    'received_amount' => $newReceived,
                    'balance_due'     => $newBalance,
                    'payment_proof'   => $filePath ?: $taxInvoice->payment_proof,
                    'status'          => 'Pending',
                ]);

                $invoice = $taxInvoice;
            } else {
                $prefix   = in_array($agreement->package, ['PKG-1', 'PACKAGE 1'], true) ? 'INV-P1-' : 'INV-E-';
                $seq      = Invoice::where('invoice_number', 'like', "{$prefix}%")
                    ->lockForUpdate()
                    ->max(DB::raw("CAST(SUBSTRING(invoice_number," . (strlen($prefix) + 1) . ") AS UNSIGNED)")) + 1;
                $invNo    = $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
                $received = min($payment, $totalAmount);
                $balance  = max($totalAmount - $received, 0);

                $invoice = Invoice::create([
                    'agreement_reference_no' => $agreement->reference_no,
                    'invoice_type'           => 'Tax',
                    'invoice_number'         => $invNo,
                    'customer_id'            => $agreement->client_id,
                    'CL_Number'              => $agreement->CL_Number,
                    'CN_Number'              => $agreement->CN_Number,
                    'payment_method'         => $r->input('payment_method'),
                    'received_amount'        => $received,
                    'invoice_date'           => now('Asia/Dubai'),
                    'due_date'               => now('Asia/Dubai')->addDay(),
                    'total_amount'           => $totalAmount,
                    'discount_amount'        => 0,
                    'tax_amount'             => 0,
                    'balance_due'            => $balance,
                    'payment_proof'          => $filePath,
                    'status'                 => 'Pending',
                    'created_by'             => Auth::id(),
                ]);

                InvoiceItem::create([
                    'invoice_id'   => $invoice->invoice_id,
                    'product_name' => "Transfer Fee for Agreement: {$agreement->reference_no}",
                    'quantity'     => 1,
                    'unit_price'   => $totalAmount,
                    'total_price'  => $totalAmount,
                ]);
            }

            InvoiceItem::updateOrCreate(
                ['invoice_id' => $invoice->invoice_id],
                [
                    'product_name' => "Transfer Fee for Agreement: {$agreement->reference_no}",
                    'quantity'     => 1,
                    'unit_price'   => $totalAmount,
                    'total_price'  => $totalAmount,
                ]
            );

            $this->journalPending($invoice, $totalAmount, $invoice->balance_due);

            $this->notify([
                'role'       => 'finance',
                'title'      => "Pending Invoice {$invoice->invoice_number}",
                'message'    => "Invoice {$invoice->invoice_number} pending, total AED {$totalAmount}",
                'CL_Number'  => $agreement->CL_Number,
                'CN_Number'  => $agreement->CN_Number,
                'status'     => 'Un Read',
                'created_at' => now('Asia/Dubai'),
            ]);

            return $invoice;
        });
    }

    public function changeInvoiceStatus(Request $r)
    {
        $u = Auth::user();
        if (!$u || !in_array($u->role, ['Accountant', 'Cashier', 'Finance Officer'], true)) {
            return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
        }

        $v = $r->validate([
            'invoice_id'     => ['required', 'exists:invoices,invoice_id'],
            'status'         => ['required', 'in:Pending,Paid,Partially Paid,Overdue,Cancelled,Hold,Unpaid'],
            'amount_paid'    => ['nullable', 'numeric', 'min:0'],
            'payment_method' => ['nullable', 'string'],
        ]);

        try {
            return DB::transaction(function () use ($v) {
                $invoice = Invoice::lockForUpdate()->findOrFail($v['invoice_id']);
                $status  = $v['status'];
                $color   = '#6c757d';
                $msg     = 'Invoice status updated';

                if (in_array($status, ['Paid', 'Partially Paid'], true) && empty($v['payment_method'])) {
                    return response()->json(['success' => false, 'message' => 'Payment method required'], 422);
                }

                if ($status === 'Paid') {
                    $this->journalPayment($invoice, $invoice->balance_due, $v['payment_method']);
                    $invoice->payment_method  = $v['payment_method'];
                    $invoice->received_amount = $invoice->total_amount;
                    $invoice->balance_due     = 0;
                    $msg   = 'Invoice marked as paid successfully';
                    $color = '#28a745';
                    if ($invoice->invoice_type === 'Tax') {
                        $this->createContract($invoice);
                        $msg .= ' and Contract generated';
                    }
                } elseif ($status === 'Partially Paid') {
                    $amt = (float) ($v['amount_paid'] ?? 0);
                    if ($amt <= 0 || $amt > $invoice->balance_due) {
                        return response()->json(['success' => false, 'message' => 'Invalid amount'], 422);
                    }
                    $this->journalPayment($invoice, $amt, $v['payment_method']);
                    $invoice->payment_method  = $v['payment_method'];
                    $invoice->received_amount = $invoice->received_amount + $amt;
                    $invoice->balance_due     = max($invoice->total_amount - $invoice->received_amount, 0);
                    $msg   = 'Invoice partially paid successfully';
                    $color = '#ffc107';
                } elseif ($status === 'Cancelled') {
                    $this->journalCancelled($invoice);
                    $invoice->received_amount = 0;
                    $invoice->balance_due     = 0;
                    $msg   = 'Invoice cancelled successfully';
                    $color = '#dc3545';
                } elseif (in_array($status, ['Pending', 'Unpaid'], true)) {
                    $invoice->received_amount = 0;
                    $invoice->balance_due     = $invoice->total_amount;
                }

                $invoice->status   = $status;
                $invoice->due_date = now('Asia/Dubai')->toDateString();
                $invoice->save();

                return response()->json([
                    'success'     => true,
                    'message'     => $msg,
                    'statusColor' => $color,
                    'invoice'     => $invoice,
                ]);
            }, 5);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Server error'], 500);
        }
    }

    private function createContract(Invoice $invoice): void
    {
        $agr = Agreement::where('reference_no', $invoice->agreement_reference_no)
            ->lockForUpdate()
            ->first();

        if (!$agr) {
            throw new \Exception('Agreement not found');
        }

        if (Contract::where('agreement_reference_no', $agr->reference_no)->exists()) {
            return;
        }

        $prefix = 'CT-';
        $seq    = Contract::where('reference_no', 'like', "{$prefix}%")
            ->lockForUpdate()
            ->max(DB::raw("CAST(SUBSTRING(reference_no," . (strlen($prefix) + 1) . ") AS UNSIGNED)")) + 1;
        $refNo  = $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);

        Contract::create([
            'reference_no'           => $refNo,
            'agreement_type'         => $agr->agreement_type,
            'agreement_reference_no' => $agr->reference_no,
            'candidate_id'           => $agr->candidate_id,
            'CL_Number'              => $agr->CL_Number,
            'CN_Number'              => $agr->CN_Number,
            'reference_of_candidate' => $agr->reference_of_candidate,
            'package'                => $agr->package,
            'foreign_partner'        => $agr->foreign_partner,
            'client_id'              => $agr->client_id,
            'contract_start_date'    => $agr->agreement_start_date,
            'contract_end_date'      => $agr->agreement_end_date,
            'contract_signed_copy'   => null,
            'maid_delivered'         => 'Yes',
            'transferred_date'       => now('Asia/Dubai'),
            'remarks'                => 'Auto generated and not edited yet',
            'status'                 => 'Active',
        ]);

        $this->notify([
            'role'       => 'operations',
            'title'      => "Contract {$refNo} created",
            'message'    => "Contract {$refNo} generated from Agreement {$agr->reference_no}",
            'CL_Number'  => $agr->CL_Number,
            'CN_Number'  => $agr->CN_Number,
            'status'     => 'Un Read',
            'created_at' => now('Asia/Dubai'),
        ]);
    }

    private function journalPending(Invoice $i, float $total, float $balance): void
    {
        $j = JournalEntries::create([
            'journal_date' => now('Asia/Dubai'),
            'description'  => "Invoice Pending: {$i->invoice_number}",
            'reference_no' => $i->invoice_number,
            'total_debit'  => $total,
            'total_credit' => $total,
            'status'       => 'Approved',
        ]);

        JournalEntryDetails::insert([
            ['journal_id' => $j->journal_id, 'account_code' => 1100, 'debit_amount' => $total, 'credit_amount' => 0, 'description' => "AR {$i->invoice_number}"],
            ['journal_id' => $j->journal_id, 'account_code' => 3000, 'debit_amount' => 0, 'credit_amount' => $balance, 'description' => "Sales {$i->invoice_number}"],
            ['journal_id' => $j->journal_id, 'account_code' => 2100, 'debit_amount' => 0, 'credit_amount' => 0, 'description' => "VAT {$i->invoice_number}"],
        ]);
    }

    private function journalPayment(Invoice $i, float $amount, ?string $method): void
    {
        if (!$method) {
            throw new \Exception('Payment method required');
        }

        $account = DB::table('payment_methods')->where('name', $method)->value('account_code');
        if (!$account) {
            throw new \Exception('Invalid payment method');
        }

        $j = JournalEntries::create([
            'journal_date' => now('Asia/Dubai'),
            'description'  => "Payment: {$i->invoice_number}",
            'reference_no' => $i->invoice_number,
            'total_debit'  => $amount,
            'total_credit' => $amount,
            'status'       => 'Approved',
        ]);

        JournalEntryDetails::insert([
            ['journal_id' => $j->journal_id, 'account_code' => $account, 'debit_amount' => $amount, 'credit_amount' => 0, 'description' => "Received via {$method}"],
            ['journal_id' => $j->journal_id, 'account_code' => 1100, 'debit_amount' => 0, 'credit_amount' => $amount, 'description' => "AR Payment {$i->invoice_number}"],
        ]);
    }

    private function journalCancelled(Invoice $i): void
    {
        $j = JournalEntries::create([
            'journal_date' => now('Asia/Dubai'),
            'description'  => "Cancelled: {$i->invoice_number}",
            'reference_no' => $i->invoice_number,
            'total_debit'  => $i->total_amount,
            'total_credit' => $i->total_amount,
            'status'       => 'Approved',
        ]);

        JournalEntryDetails::insert([
            ['journal_id' => $j->journal_id, 'account_code' => 1100, 'debit_amount' => 0, 'credit_amount' => $i->total_amount, 'description' => "Rev AR {$i->invoice_number}"],
            ['journal_id' => $j->journal_id, 'account_code' => 3000, 'debit_amount' => $i->total_amount, 'credit_amount' => 0, 'description' => "Rev Sales {$i->invoice_number}"],
            ['journal_id' => $j->journal_id, 'account_code' => 2100, 'debit_amount' => $i->tax_amount, 'credit_amount' => 0, 'description' => "Rev VAT {$i->invoice_number}"],
        ]);
    }
}
