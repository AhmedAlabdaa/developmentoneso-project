<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\InvoiceItem;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\Notification;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    private const ALLOWED_ROLES = ['Accountant', 'Cashier', 'Finance Officer'];

    protected function notify(array $d): void
    {
        Notification::create($d);
    }

    private function assertFinanceRole(): void
    {
        $user = auth()->user();
        if (!$user || !in_array($user->role, self::ALLOWED_ROLES, true)) {
            if (request()->expectsJson()) {
                response()->json(['success' => false, 'message' => 'Forbidden'], 403)->send();
                exit;
            }
            abort(403);
        }
    }

    public function index(Request $r)
    {
        $now  = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $tab  = strtoupper($r->input('tab', 'RVO'));
        $like = $tab === 'RVO' ? 'RVO-P1-%' : ($tab === 'RVI' ? 'RVI-P1-%' : ($tab === 'INV' ? 'INV-P1-%' : null));

        $q = Invoice::query()
            ->leftJoin('crm', 'invoices.customer_id', 'crm.id')
            ->leftJoin('agreements', 'invoices.agreement_reference_no', 'agreements.reference_no')
            ->select('invoices.*')
            ->with(['journal'])
            ->groupBy('invoices.invoice_id');

        if ($like)                            $q->where('invoices.invoice_number', 'like', $like);
        if ($r->filled('status')          && $r->status !== 'all')         $q->where('invoices.status', $r->status);
        if ($r->filled('invoice_number')  && $r->invoice_number !== 'all') $q->where('invoices.invoice_number', $r->invoice_number);
        if ($r->filled('CN_Number')       && $r->CN_Number !== 'all')      $q->where('invoices.CN_Number', $r->CN_Number);
        if ($r->filled('CL_Number')       && $r->CL_Number !== 'all')      $q->where('invoices.CL_Number', $r->CL_Number);
        if ($r->filled('payment_method')  && $r->payment_method !== 'all') $q->where('invoices.payment_method', $r->payment_method);
        if ($r->filled('customer_name'))                                   $q->whereRaw("CONCAT(crm.first_name,' ',crm.last_name) LIKE ?", ["%{$r->customer_name}%"]);
        if ($r->filled('candidate_name'))                                  $q->where('agreements.candidate_name', 'like', "%{$r->candidate_name}%");
        if ($r->filled('from_date'))                                       $q->whereDate('invoices.created_at', '>=', $r->from_date);
        if ($r->filled('end_date'))                                        $q->whereDate('invoices.created_at', '<=', $r->end_date);
        if ($r->filled('global_search')) {
            $s = $r->global_search;
            $q->where(fn($q) => $q
                ->where('invoices.invoice_number', 'like', "%{$s}%")
                ->orWhereRaw("CONCAT(crm.first_name,' ',crm.last_name) LIKE ?", ["%{$s}%"])
            );
        }

        $dir = strtoupper($r->input('sort_by', 'all'));
        if (in_array($dir, ['ASC','DESC'], true)) {
            $q->orderByRaw("CASE WHEN invoices.due_date IS NULL THEN 1 ELSE 0 END, invoices.due_date $dir");
        } else {
            $q->orderByDesc('invoices.invoice_number');
        }

        $invoices = $q->paginate(10)->appends($r->except('page'));

        if ($r->ajax()) {
            $html = $invoices->isEmpty()
                ? '<div class="no-data">No records found</div>'
                : view('invoices.partials.invoice_table', compact('invoices'))->render();
            return response()->json(['html' => $html, 'now' => $now]);
        }

        return view('invoices.index', compact('invoices', 'now'));
    }

    public function show(string $inv)
    {
        $invoice = Invoice::where('invoice_number', $inv)->firstOrFail();
        $ids     = Invoice::where('agreement_reference_no', $invoice->agreement_reference_no)
                          ->where('invoice_type', $invoice->invoice_type)
                          ->pluck('invoice_id');
        $invoiceItems   = InvoiceItem::whereIn('invoice_id', $ids)->get();
        $receivedAmount = Invoice::whereIn('invoice_id', $ids)->sum('received_amount');
        $balanceDue     = $invoice->total_amount - $receivedAmount;
        $now            = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        // Load receipt vouchers with journal for this invoice
        $receiptVouchers = $invoice->receiptVouchers()->with('journal.lines.ledger')->get();

        if (str_starts_with($invoice->invoice_number, 'RVI-')) {
            $view = 'invoices.receipt_voucher';
        } else {
            $view = $invoice->invoice_type === 'Tax'
                ? 'invoices.show1'
                : ($invoice->invoice_type === 'Installment' ? 'invoices.show2' : 'invoices.show');
        }

        return view($view, compact('invoice', 'invoiceItems', 'now', 'receivedAmount', 'balanceDue', 'receiptVouchers'));
    }

    public function download(string $inv)
    {
        $invoice = Invoice::where('invoice_number', $inv)->firstOrFail();
        $ids     = Invoice::where('agreement_reference_no', $invoice->agreement_reference_no)
                          ->where('invoice_type', $invoice->invoice_type)
                          ->pluck('invoice_id');
        $invoiceItems   = InvoiceItem::whereIn('invoice_id', $ids)->get();
        $receivedAmount = Invoice::whereIn('invoice_id', $ids)->sum('received_amount');
        $balanceDue     = $invoice->total_amount - $receivedAmount;
        $now            = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $view = $invoice->invoice_type === 'Tax'
            ? 'invoices.download1'
            : ($invoice->invoice_type === 'Installment' ? 'invoices.download2' : 'invoices.download');

        $pdf = PDF::loadView($view, compact('invoice', 'invoiceItems', 'now', 'receivedAmount', 'balanceDue'))
            ->setOption('encoding', 'UTF-8')
            ->setOption('enable-local-file-access', true)
            ->setPaper('a4')
            ->setOrientation('portrait');

        return $pdf->stream("{$invoice->invoice_type}_Invoice_{$invoice->invoice_number}.pdf");
    }

    public function share($inv)
    {
        $url = route('invoice.download', ['invoiceNumber' => $inv]);
        return redirect()->away("https://wa.me/?text=" . urlencode("Please check the invoice: {$inv}\n{$url}"));
    }

    public function store(Request $r)
    {
        $this->assertFinanceRole();

        $r->validate([
            'agreement_reference_no' => 'required|exists:agreements,reference_no',
            'invoice_date'           => 'required|date',
            'due_date'               => 'required|date|after_or_equal:invoice_date',
            'customer_id'            => 'required|exists:crm,id',
            'particulars.*'          => 'required|string',
            'quantities.*'           => 'required|integer|min:1',
            'prices.*'               => 'required|numeric|min:0',
            'subtotal'               => 'required|numeric|min:0',
            'vat_amount'             => 'required|numeric|min:0',
            'grand_total'            => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($r) {
            $agr  = Agreement::where('reference_no', $r->agreement_reference_no)->firstOrFail();
            $pref = in_array($agr->package, ['PKG-1', 'PACKAGE 1'], true) ? 'INV-P1-' : 'INV-E-';
            $seq  = Invoice::where('invoice_number', 'like', "$pref%")
                ->lockForUpdate()
                ->max(DB::raw("CAST(SUBSTRING(invoice_number, " . (strlen($pref) + 1) . ") AS UNSIGNED)")) + 1;
            $invNo = $pref . str_pad($seq, 5, '0', STR_PAD_LEFT);

            $inv = Invoice::create([
                'agreement_reference_no' => $r->agreement_reference_no,
                'invoice_number'         => $invNo,
                'customer_id'            => $r->customer_id,
                'invoice_date'           => $r->invoice_date,
                'due_date'               => $r->due_date,
                'subtotal'               => $r->subtotal,
                'vat_amount'             => $r->vat_amount,
                'total_amount'           => $r->grand_total,
                'balance_due'            => $r->grand_total,
                'status'                 => 'Pending',
                'notes'                  => $r->notes,
                'created_by'             => auth()->id(),
            ]);

            foreach ($r->particulars as $i => $p) {
                InvoiceItem::create([
                    'invoice_id'   => $inv->invoice_id,
                    'product_name' => $p,
                    'quantity'     => $r->quantities[$i],
                    'unit_price'   => $r->prices[$i],
                    'total_price'  => $r->quantities[$i] * $r->prices[$i],
                ]);
            }
        });

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function updateStatus(Request $request)
    {
        $this->assertFinanceRole();

        $data = $request->validate([
            'invoice_id'   => 'required|exists:invoices,invoice_id',
            'status_name'  => 'required|in:Pending,Unpaid,Paid,Partially Paid,Overdue,Cancelled,Hold,COD,Replacement',
            'amount_paid'  => 'nullable|numeric|min:0',
        ]);

        $statusColors = [
            'Paid'           => '#28a745',
            'Partially Paid' => '#ffc107',
            'Cancelled'      => '#dc3545',
        ] + array_fill_keys(
            ['Pending','Unpaid','Overdue','Hold','COD','Replacement'],
            '#6c757d'
        );

        $statusMessages = [
            'Paid'           => 'Invoice marked as paid successfully',
            'Partially Paid' => 'Invoice partially paid successfully',
            'Cancelled'      => 'Invoice cancelled successfully',
        ] + array_fill_keys(
            ['Pending','Unpaid','Overdue','Hold','COD','Replacement'],
            'Invoice status updated'
        );

        $agreementStatusMap = [
            'Proforma' => ['Paid', 'Partially Paid'],
            'Tax'      => ['Paid', 'Partially Paid'],
        ];

        $agreementStatusCode = [
            'Proforma' => 2,
            'Tax'      => 5,
        ];

        $eligibleContractStatuses = ['Paid','Partially Paid','COD','Replacement'];

        try {
            [$message, $color] = DB::transaction(function () use (
                $data,
                $statusColors,
                $statusMessages,
                $agreementStatusMap,
                $agreementStatusCode,
                $eligibleContractStatuses
            ) {
                $invoice = Invoice::lockForUpdate()->findOrFail($data['invoice_id']);
                $agreement = Agreement::where('reference_no', $invoice->agreement_reference_no)
                    ->lockForUpdate()
                    ->firstOrFail();

                $status = $data['status_name'];
                $invoice->status   = $status;
                $invoice->due_date = Carbon::now('Asia/Dubai')->toDateString();

                switch ($status) {
                    case 'Paid':
                        $invoice->received_amount = $invoice->total_amount;
                        $invoice->balance_due     = 0;
                        break;
                    case 'Partially Paid':
                        $paid = (float) ($data['amount_paid'] ?? 0);
                        $invoice->received_amount += $paid;
                        $invoice->balance_due = max($invoice->total_amount - $invoice->received_amount, 0);
                        break;
                    case 'Cancelled':
                        $invoice->received_amount = 0;
                        $invoice->balance_due     = 0;
                        break;
                    default:
                        $invoice->received_amount = 0;
                        $invoice->balance_due     = $invoice->total_amount;
                        break;
                }

                $invoice->save();

                if (
                    isset($agreementStatusMap[$invoice->invoice_type]) &&
                    in_array($status, $agreementStatusMap[$invoice->invoice_type], true)
                ) {
                    $expectedStatus = $agreementStatusCode[$invoice->invoice_type];
                    $rows = $agreement->newQuery()
                        ->whereKey($agreement->getKey())
                        ->update(['status' => $expectedStatus]);

                    if ($rows !== 1) {
                        throw new \RuntimeException("Agreement status could not be updated for {$agreement->reference_no}.");
                    }

                    $agreement->refresh();
                    if ((int) $agreement->status !== $expectedStatus) {
                        throw new \RuntimeException("Agreement status mismatch after update for {$agreement->reference_no}.");
                    }
                }

                $contractMsg = '';

                if (
                    $invoice->invoice_type === 'Tax' &&
                    in_array($status, $eligibleContractStatuses, true)
                ) {
                    $existing = Contract::where('agreement_reference_no', $agreement->reference_no)
                        ->lockForUpdate()
                        ->first();

                    if ($existing) {
                        $contractMsg = "Contract {$existing->reference_no} already exists";
                    } else {
                        $prefix = in_array($agreement->package, ['PKG-1','PACKAGE 1'], true) ? 'CT-' : 'CT-E-';
                        $maxSeq = Contract::where('reference_no', 'like', "{$prefix}%")
                            ->lockForUpdate()
                            ->max(DB::raw(
                                "CAST(SUBSTRING(reference_no," . (strlen($prefix) + 1) . ") AS UNSIGNED)"
                            ));

                        $newRef = $prefix . str_pad((($maxSeq ?: 0) + 1), 5, '0', STR_PAD_LEFT);

                        Contract::create([
                            'reference_no'           => $newRef,
                            'agreement_type'         => $agreement->agreement_type,
                            'agreement_reference_no' => $agreement->reference_no,
                            'candidate_id'           => $agreement->candidate_id,
                            'CL_Number'              => $agreement->CL_Number,
                            'CN_Number'              => $agreement->CN_Number,
                            'reference_of_candidate' => $agreement->reference_of_candidate,
                            'package'                => $agreement->package,
                            'foreign_partner'        => $agreement->foreign_partner,
                            'client_id'              => $agreement->client_id,
                            'salary'                 => $agreement->salary,
                            'passport_no'            => $agreement->passport_no,
                            'emp_reference_no'       => $agreement->CN_Number,
                            'nationality'            => $agreement->nationality,
                            'candidate_name'         => $agreement->candidate_name,
                            'contract_start_date'    => $agreement->agreement_start_date,
                            'contract_end_date'      => $agreement->agreement_end_date,
                            'sales_name'             => $agreement->created_by,
                            'created_by'             => auth()->id(),
                            'maid_delivered'         => 'Yes',
                            'transferred_date'       => Carbon::now('Asia/Dubai'),
                            'remarks'                => 'Auto generated and not edited yet',
                            'status'                 => 2,
                        ]);

                        $agreement->status = $agreementStatusCode['Tax'];
                        $agreement->save();

                        if (in_array($agreement->package, ['PKG-1','PACKAGE 1'], true)) {
                            Package::where('passport_no', $agreement->passport_no)
                                ->lockForUpdate()
                                ->update(['inside_status' => 6]);
                        }

                        $contractMsg = "Contract {$newRef} generated";
                    }
                }

                if (\Illuminate\Support\Str::startsWith($invoice->invoice_id, 'INV-INS-')) {
                    $installment = Installment::lockForUpdate()
                        ->where('invoice_id', $invoice->invoice_id)
                        ->first();

                    if ($installment) {
                        $installment->paid_installments = ($installment->paid_installments ?? 0) + 1;
                        $installment->save();

                        $item = InstallmentItem::where('installment_id', $installment->id)
                            ->where('status', '!=', 'Paid')
                            ->orderBy('id')
                            ->first();

                        if ($item) {
                            $item->status    = 'Paid';
                            $item->paid_date = Carbon::now('Asia/Dubai')->toDateString();
                            $item->save();
                        }
                    }
                }

                $baseMsg = $statusMessages[$status];
                $fullMsg = $contractMsg ? "{$baseMsg} – {$contractMsg}" : $baseMsg;

                return [$fullMsg, $statusColors[$status]];
            }, 5);

            return response()->json([
                'success'     => true,
                'message'     => $message,
                'statusColor' => $color,
            ]);
        } catch (\RuntimeException $e) {
            Log::notice('updateStatus business rule failed', ['msg' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('updateStatus failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Unexpected server error',
            ], 500);
        }
    }

    public function updatePaymentMethod(Request $r, $inv)
    {
        $this->assertFinanceRole();

        $v = $r->validate(['payment_method' => 'required|string']);
        $i = Invoice::where('invoice_number', $inv)->firstOrFail();
        $i->payment_method = $v['payment_method'];
        $i->save();
        return response()->json(['success' => true, 'message' => 'Payment method updated']);
    }

    public function updateInvoice(Request $request)
    {
        $this->assertFinanceRole();

        try {
            $data = $request->validate([
                'invoice_id'      => ['required', 'integer', 'exists:invoices,invoice_id'],
                'total_amount'    => ['required', 'numeric', 'min:0'],
                'received_amount' => ['required', 'numeric', 'min:0', 'lte:total_amount'],
                'payment_method'  => ['required', 'string'],
                'payment_proof'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ]);

            $invoice = Invoice::findOrFail($data['invoice_id']);

            DB::transaction(function () use ($data, $request, $invoice) {
                $invoice->total_amount    = $data['total_amount'];
                $invoice->received_amount = $data['received_amount'];
                $invoice->payment_method  = $data['payment_method'];

                if ($request->hasFile('payment_proof')) {
                    if ($invoice->payment_proof && Storage::disk('public')->exists($invoice->payment_proof)) {
                        Storage::disk('public')->delete($invoice->payment_proof);
                    }
                    $invoice->payment_proof = $request->file('payment_proof')->store('payment_proofs', 'public');
                }

                $invoice->save();

                InvoiceItem::where('invoice_id', $invoice->invoice_id)
                    ->update([
                        'quantity'    => 1,
                        'unit_price'  => $invoice->total_amount,
                        'total_price' => $invoice->total_amount,
                    ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Invoice and items updated successfully!',
                'data'    => [
                    'invoice_id'      => $invoice->invoice_id,
                    'total_amount'    => number_format($invoice->total_amount, 2, '.', ''),
                    'received_amount' => number_format($invoice->received_amount, 2, '.', ''),
                    'payment_method'  => $invoice->payment_method,
                    'payment_proof'   => $invoice->payment_proof ? Storage::url($invoice->payment_proof) : null,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed. Please try again.',
            ], 500);
        }
    }
}
