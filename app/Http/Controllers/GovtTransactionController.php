<?php

namespace App\Http\Controllers;

use App\Models\CRM;
use App\Models\NewCandidate;
use App\Models\Service;
use App\Models\GovtTransactionInvoice;
use App\Models\GovtTransactionInvoiceItem;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GovtTransactionController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $query = GovtTransactionInvoice::with('items')->orderByDesc('invoice_number');

        if ($request->filled('CL_Number')) {
            $query->where('CL_Number', 'like', '%' . $request->CL_Number . '%');
        }

        if ($request->filled('agreement_no')) {
            $query->where('CN_Number', 'like', '%' . $request->agreement_no . '%');
        }

        if ($request->filled(['from_date', 'to_date'])) {
            $from = Carbon::parse($request->from_date)->startOfDay()->format('Y-m-d');
            $to = Carbon::parse($request->to_date)->endOfDay()->format('Y-m-d');
            $query->whereBetween('invoice_date', [$from, $to]);
        }

        $user = Auth::user();
        $roles = ['Admin', 'Managing Director', 'Accountant', 'Cashier', 'Finance Officer', 'Operations Manager'];

        if (!in_array($user->role, $roles, true)) {
            $query->where('created_by', $user->id);
        }

        $invoices = $query->paginate(10)->appends($request->except('page'));

        if ($request->ajax()) {
            $html = view('govt_transactions.partials.invoice_table', compact('invoices'))->render();
            if ($invoices->isEmpty()) {
                $html = '<div class="no-data">No records found</div>';
            }
            return response()->json(['html' => $html, 'now' => $now]);
        }

        return view('govt_transactions.index', compact('invoices', 'now'));
    }

    public function create()
    {
        $customers = CRM::latest()->get();
        $candidates = NewCandidate::latest()->get();
        $services = Service::latest()->get();
        $nextIndoor = $this->peekNextInvoiceNumber('Indoor');
        $nextWalking = $this->peekNextInvoiceNumber('Walking');
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        return view('govt_transactions.create', compact('now', 'customers', 'candidates', 'services', 'nextIndoor', 'nextWalking'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mohre_ref' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'customer_type' => ['required', Rule::in(['Indoor', 'Walking'])],
            'customer_id' => 'required|exists:crm,id',
            'candidate_id' => [Rule::requiredIf(fn () => $request->customer_type === 'Indoor'), 'nullable', 'exists:new_candidates,id'],
            'service_name' => 'required|array|min:1',
            'service_name.*' => 'required|string|max:255',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|numeric|min:1',
            'rates' => 'required|array|min:1',
            'rates.*' => 'required|numeric|min:0',
            'taxes' => 'nullable|array',
            'taxes.*' => 'nullable|numeric|min:0',
            'center_fees' => 'nullable|array',
            'center_fees.*' => 'nullable|numeric|min:0',
            'dw_numbers' => 'nullable|array',
            'dw_numbers.*' => 'nullable|string|max:255',
            'payment_mode' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'received_amount' => 'nullable|numeric|min:0',
            'payment_note' => 'nullable|string|max:1000',
            'currency' => 'nullable|string|max:10',
            'discount_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);

        $invoice = DB::transaction(function () use ($request) {
            $invoiceNumber = $this->nextInvoiceNumber($request->customer_type);
            $invoiceDate = Carbon::parse($request->invoice_date)->format('Y-m-d');

            $subtotal = 0.0;
            $vatTotal = 0.0;
            $centerTotal = 0.0;
            $items = [];

            $names = $request->service_name;
            $qtys = $request->quantities;
            $rates = $request->rates;
            $taxes = $request->taxes ?? [];
            $centers = $request->center_fees ?? [];
            $dws = $request->dw_numbers ?? [];

            foreach ($names as $i => $serviceName) {
                $qty = (float) ($qtys[$i] ?? 0);
                $rate = (float) ($rates[$i] ?? 0);
                $taxPct = (float) ($taxes[$i] ?? 0);
                $center = (float) ($centers[$i] ?? 0);
                $dw = $dws[$i] ?? null;

                $base = $qty * $rate;
                $vat = $base * ($taxPct / 100);
                $lineTotal = $base + $vat + $center;

                $subtotal += $base;
                $vatTotal += $vat;
                $centerTotal += $center;

                $items[] = [
                    'invoice_number' => $invoiceNumber,
                    'service_name' => $serviceName,
                    'dw_number' => $dw,
                    'qty' => $qty,
                    'amount' => $rate,
                    'tax' => $taxPct,
                    'center_fee' => $center,
                    'total' => $lineTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $discount = (float) ($request->discount_amount ?? 0);
            $grossTotal = $subtotal + $vatTotal + $centerTotal;
            $grandTotal = max($grossTotal - $discount, 0);
            $received = $request->filled('received_amount') ? (float) $request->received_amount : $grandTotal;
            $received = max($received, 0);
            $remaining = max($grandTotal - $received, 0);
            $status = $received == 0 ? 'Pending' : ($received < $grandTotal ? 'Partial Paid' : 'Paid');

            $cust = CRM::findOrFail($request->customer_id);

            $data = [
                'invoice_number' => $invoiceNumber,
                'mohre_ref' => $request->mohre_ref,
                'invoice_date' => $invoiceDate,
                'customer_type' => $request->customer_type,
                'customer_id' => $request->customer_id,
                'candidate_id' => $request->filled('candidate_id') ? $request->candidate_id : null,
                'total_amount' => $subtotal,
                'total_vat' => $vatTotal,
                'total_center_fee' => $centerTotal,
                'discount_amount' => $discount,
                'net_total' => $grandTotal,
                'received_amount' => $received,
                'remaining_amount' => $remaining,
                'status' => $status,
                'currency' => $request->input('currency', 'AED'),
                'due_date' => $request->due_date ? Carbon::parse($request->due_date)->format('Y-m-d') : null,
                'payment_reference' => $request->payment_reference,
                'notes' => $request->notes,
                'payment_mode' => $request->input('payment_mode', 'Cash'),
                'payment_note' => $request->payment_note,
                'created_by' => Auth::id(),
                'CL_Number' => $cust->CN_Number,
                'Customer_name' => trim(($cust->first_name ?? '') . ' ' . ($cust->last_name ?? '')),
                'Customer_mobile_no' => $cust->mobile,
                'Sales_name' => trim((Auth::user()->first_name ?? '') . ' ' . (Auth::user()->last_name ?? '')),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($request->filled('candidate_id')) {
                $cand = NewCandidate::findOrFail($request->candidate_id);
                $data['candidate_name'] = $cand->candidate_name;
                $data['CN_Number'] = $cand->CN_Number;
            }

            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $data['payment_proof'] = basename($path);

            $invoice = GovtTransactionInvoice::create($data);
            GovtTransactionInvoiceItem::insert($items);

            return $invoice;
        });

        return redirect()->route('govt-transactions.index')->with('success', "Invoice {$invoice->invoice_number} created successfully.");
    }

    public function show($invoice_number)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $invoice = GovtTransactionInvoice::with('items')
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        return view('govt_transactions.show', compact('invoice', 'now'));
    }

    public function edit($invoice_number)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        $invoice = GovtTransactionInvoice::with('items')
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        $customers = CRM::latest()->get();
        $candidates = NewCandidate::latest()->get();
        $services = Service::latest()->get();

        return view('govt_transactions.edit', compact('invoice', 'now', 'customers', 'candidates', 'services'));
    }

    public function update(Request $request, $invoice_number)
    {
        $invoice = GovtTransactionInvoice::where('invoice_number', $invoice_number)->firstOrFail();

        $request->validate([
            'mohre_ref' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'customer_type' => ['required', Rule::in(['Indoor', 'Walking'])],
            'customer_id' => 'required|exists:crm,id',
            'candidate_id' => [Rule::requiredIf(fn () => $request->customer_type === 'Indoor'), 'nullable', 'exists:new_candidates,id'],
            'service_name' => 'required|array|min:1',
            'service_name.*' => 'required|string|max:255',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|numeric|min:1',
            'rates' => 'required|array|min:1',
            'rates.*' => 'required|numeric|min:0',
            'taxes' => 'nullable|array',
            'taxes.*' => 'nullable|numeric|min:0',
            'center_fees' => 'nullable|array',
            'center_fees.*' => 'nullable|numeric|min:0',
            'dw_numbers' => 'nullable|array',
            'dw_numbers.*' => 'nullable|string|max:255',
            'payment_mode' => 'required|string|max:255',
            'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'received_amount' => 'nullable|numeric|min:0',
            'payment_note' => 'nullable|string|max:1000',
            'currency' => 'nullable|string|max:10',
            'discount_amount' => 'nullable|numeric|min:0',
            'due_date' => 'nullable|date',
            'payment_reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($request, $invoice, $invoice_number) {
            $invoiceDate = Carbon::parse($request->invoice_date)->format('Y-m-d');

            $subtotal = 0.0;
            $vatTotal = 0.0;
            $centerTotal = 0.0;
            $items = [];

            $names = $request->service_name;
            $qtys = $request->quantities;
            $rates = $request->rates;
            $taxes = $request->taxes ?? [];
            $centers = $request->center_fees ?? [];
            $dws = $request->dw_numbers ?? [];

            foreach ($names as $i => $serviceName) {
                $qty = (float) ($qtys[$i] ?? 0);
                $rate = (float) ($rates[$i] ?? 0);
                $taxPct = (float) ($taxes[$i] ?? 0);
                $center = (float) ($centers[$i] ?? 0);
                $dw = $dws[$i] ?? null;

                $base = $qty * $rate;
                $vat = $base * ($taxPct / 100);
                $lineTotal = $base + $vat + $center;

                $subtotal += $base;
                $vatTotal += $vat;
                $centerTotal += $center;

                $items[] = [
                    'invoice_number' => $invoice_number,
                    'service_name' => $serviceName,
                    'dw_number' => $dw,
                    'qty' => $qty,
                    'amount' => $rate,
                    'tax' => $taxPct,
                    'center_fee' => $center,
                    'total' => $lineTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $discount = (float) ($request->discount_amount ?? 0);
            $grossTotal = $subtotal + $vatTotal + $centerTotal;
            $grandTotal = max($grossTotal - $discount, 0);
            $received = $request->filled('received_amount') ? (float) $request->received_amount : $grandTotal;
            $received = max($received, 0);
            $remaining = max($grandTotal - $received, 0);
            $status = $received == 0 ? 'Pending' : ($received < $grandTotal ? 'Partial Paid' : 'Paid');

            $cust = CRM::findOrFail($request->customer_id);

            $data = [
                'mohre_ref' => $request->mohre_ref,
                'invoice_date' => $invoiceDate,
                'customer_type' => $request->customer_type,
                'customer_id' => $request->customer_id,
                'candidate_id' => $request->filled('candidate_id') ? $request->candidate_id : null,
                'total_amount' => $subtotal,
                'total_vat' => $vatTotal,
                'total_center_fee' => $centerTotal,
                'discount_amount' => $discount,
                'net_total' => $grandTotal,
                'received_amount' => $received,
                'remaining_amount' => $remaining,
                'status' => $status,
                'currency' => $request->input('currency', $invoice->currency ?? 'AED'),
                'due_date' => $request->due_date ? Carbon::parse($request->due_date)->format('Y-m-d') : null,
                'payment_reference' => $request->payment_reference,
                'notes' => $request->notes,
                'payment_mode' => $request->input('payment_mode', 'Cash'),
                'payment_note' => $request->payment_note,
                'CL_Number' => $cust->CN_Number,
                'Customer_name' => trim(($cust->first_name ?? '') . ' ' . ($cust->last_name ?? '')),
                'Customer_mobile_no' => $cust->mobile,
                'updated_at' => now(),
            ];

            if ($request->filled('candidate_id')) {
                $cand = NewCandidate::findOrFail($request->candidate_id);
                $data['candidate_name'] = $cand->candidate_name;
                $data['CN_Number'] = $cand->CN_Number;
            } else {
                $data['candidate_name'] = null;
                $data['CN_Number'] = null;
            }

            if ($request->hasFile('payment_proof')) {
                $old = $invoice->payment_proof ? ('payment_proofs/' . $invoice->payment_proof) : null;
                $path = $request->file('payment_proof')->store('payment_proofs', 'public');
                $data['payment_proof'] = basename($path);
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }

            $invoice->update($data);

            $invoice->items()->delete();
            GovtTransactionInvoiceItem::insert($items);
        });

        return redirect()->route('govt-transactions.index')->with('success', "Invoice {$invoice_number} updated successfully.");
    }

    public function download($invoice_number)
    {
        $invoice = GovtTransactionInvoice::where('invoice_number', $invoice_number)->firstOrFail();

        $host = request()->getHost();
        $subdomain = explode('.', $host)[0] ?? 'default';
        $header = strtolower($subdomain) . '_header.jpg';
        $footer = strtolower($subdomain) . '_footer.jpg';

        $pdf = PDF::loadView('govt_transactions.download', compact('invoice', 'header', 'footer'));
        return $pdf->stream("{$invoice_number}.pdf");
    }

    public function destroy($invoice_number)
    {
        $invoice = GovtTransactionInvoice::where('invoice_number', $invoice_number)->firstOrFail();

        DB::transaction(function () use ($invoice) {
            if ($invoice->payment_proof) {
                $path = 'payment_proofs/' . $invoice->payment_proof;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }

            $invoice->items()->delete();
            $invoice->delete();
        });

        return redirect()->route('govt-transactions.index')->with('success', 'Invoice deleted successfully.');
    }

    public function changeStatus(Request $request)
    {
        $table = (new GovtTransactionInvoice)->getTable();

        $validated = $request->validate([
            'invoice_number' => "required|exists:{$table},invoice_number",
            'status' => ['required', Rule::in(['Pending', 'Partial Paid', 'Paid', 'Cancelled'])],
        ]);

        GovtTransactionInvoice::where('invoice_number', $validated['invoice_number'])
            ->update(['status' => $validated['status'], 'updated_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => "Status for #{$validated['invoice_number']} updated to {$validated['status']}.",
            'new_status' => $validated['status'],
        ]);
    }

    private function peekNextInvoiceNumber(string $customerType): string
    {
        $prefix = $customerType === 'Indoor' ? 'GV-INV-' : 'GVWC-INV-';
        $last = GovtTransactionInvoice::where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('invoice_number')
            ->first();

        $seq = $last ? ((int) substr($last->invoice_number, strlen($prefix)) + 1) : 1;
        return $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    private function nextInvoiceNumber(string $customerType): string
    {
        $prefix = $customerType === 'Indoor' ? 'GV-INV-' : 'GVWC-INV-';

        $row = DB::table((new GovtTransactionInvoice)->getTable())
            ->where('invoice_number', 'like', $prefix . '%')
            ->select('invoice_number')
            ->orderByDesc('invoice_number')
            ->lockForUpdate()
            ->first();

        $seq = $row ? ((int) substr($row->invoice_number, strlen($prefix)) + 1) : 1;

        return $prefix . str_pad($seq, 5, '0', STR_PAD_LEFT);
    }

    private function invoicesQuery(Request $request)
    {
        $q = GovtTransactionInvoice::query()->orderByDesc('invoice_number');

        $user = Auth::user();
        $roles = ['Admin', 'Managing Director', 'Accountant', 'Cashier', 'Finance Officer', 'Operations Manager'];
        if (!in_array($user->role, $roles, true)) {
            $q->where('created_by', $user->id);
        }

        if ($request->filled('global_search')) {
            $g = trim($request->global_search);
            $q->where(function ($w) use ($g) {
                $w->where('invoice_number', 'like', "%{$g}%")
                  ->orWhere('CL_Number', 'like', "%{$g}%")
                  ->orWhere('CN_Number', 'like', "%{$g}%")
                  ->orWhere('mohre_ref', 'like', "%{$g}%")
                  ->orWhere('Customer_name', 'like', "%{$g}%")
                  ->orWhere('candidate_name', 'like', "%{$g}%")
                  ->orWhere('Customer_mobile_no', 'like', "%{$g}%")
                  ->orWhere('payment_reference', 'like', "%{$g}%")
                  ->orWhere('payment_mode', 'like', "%{$g}%");
            });
        }

        if ($request->filled('CL_Number')) {
            $cl = trim($request->CL_Number);
            $q->where('CL_Number', 'like', "%{$cl}%");
        }

        if ($request->filled('agreement_no')) {
            $ag = trim($request->agreement_no);
            $q->where('CN_Number', 'like', "%{$ag}%");
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = Carbon::parse($request->from_date)->startOfDay();
            $to   = Carbon::parse($request->to_date)->endOfDay();
            $q->whereBetween('invoice_date', [$from, $to]);
        } elseif ($request->filled('from_date')) {
            $from = Carbon::parse($request->from_date)->startOfDay();
            $q->where('invoice_date', '>=', $from);
        } elseif ($request->filled('to_date')) {
            $to = Carbon::parse($request->to_date)->endOfDay();
            $q->where('invoice_date', '<=', $to);
        }

        return $q;
    }

    public function export(Request $request)
    {
        $rows = $this->invoicesQuery($request)->get();

        $name = 'govt-transactions-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Invoice No',
                'Invoice Date',
                'Customer Type',
                'CL Number',
                'Customer Name',
                'Customer Mobile',
                'Candidate Name',
                'CN Number',
                'MOHRE Ref',
                'Status',
                'Currency',
                'Subtotal',
                'VAT',
                'Center Fee',
                'Discount',
                'Net Total',
                'Received',
                'Remaining',
                'Payment Mode',
                'Payment Reference',
                'Due Date',
                'Notes',
                'Created By',
                'Services',
            ]);

            foreach ($rows as $inv) {
                $services = $inv->relationLoaded('items')
                    ? $inv->items
                    : $inv->items()->get(['service_name', 'qty', 'amount', 'tax', 'center_fee', 'total']);

                $servicesText = $services->map(function ($it) {
                    $qty = number_format((float)($it->qty ?? 0), 2, '.', '');
                    $rate = number_format((float)($it->amount ?? 0), 2, '.', '');
                    $tax = number_format((float)($it->tax ?? 0), 2, '.', '');
                    $center = number_format((float)($it->center_fee ?? 0), 2, '.', '');
                    $total = number_format((float)($it->total ?? 0), 2, '.', '');
                    $dw = $it->dw_number ? " DW:{$it->dw_number}" : '';
                    return "{$it->service_name}{$dw} | Qty:{$qty} | Rate:{$rate} | Tax%:{$tax} | Center:{$center} | Total:{$total}";
                })->implode(' || ');

                $invDate = $inv->invoice_date ? Carbon::parse($inv->invoice_date)->format('Y-m-d') : '';
                $dueDate = $inv->due_date ? Carbon::parse($inv->due_date)->format('Y-m-d') : '';

                fputcsv($out, [
                    $inv->invoice_number,
                    $invDate,
                    $inv->customer_type,
                    $inv->CL_Number,
                    $inv->Customer_name,
                    $inv->Customer_mobile_no,
                    $inv->candidate_name,
                    $inv->CN_Number,
                    $inv->mohre_ref,
                    $inv->status,
                    $inv->currency,
                    number_format((float)($inv->total_amount ?? 0), 2, '.', ''),
                    number_format((float)($inv->total_vat ?? 0), 2, '.', ''),
                    number_format((float)($inv->total_center_fee ?? 0), 2, '.', ''),
                    number_format((float)($inv->discount_amount ?? 0), 2, '.', ''),
                    number_format((float)($inv->net_total ?? 0), 2, '.', ''),
                    number_format((float)($inv->received_amount ?? 0), 2, '.', ''),
                    number_format((float)($inv->remaining_amount ?? 0), 2, '.', ''),
                    $inv->payment_mode,
                    $inv->payment_reference,
                    $dueDate,
                    $inv->notes,
                    (string)($inv->created_by ?? ''),
                    $servicesText,
                ]);
            }

            fclose($out);
        }, $name, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
