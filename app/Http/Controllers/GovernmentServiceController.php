<?php

namespace App\Http\Controllers;

use App\Models\GovtTransactionInvoice;
use App\Models\GovtTransactionInvoiceItem;
use App\Models\CRM;
use App\Models\NewCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Throwable;

class GovernmentServiceController extends Controller
{
    public function index()
    {
        $invoices = GovtTransactionInvoice::with('items')->orderByDesc('created_at')->paginate(15);
        return view('govt_transactions.index', compact('invoices'));
    }

    public function show(string $invoiceNumber)
    {
        $invoice = GovtTransactionInvoice::with('items')->where('invoice_number', $invoiceNumber)->firstOrFail();
        return view('govt_transactions.show', compact('invoice'));
    }

    public function download(string $invoiceNumber)
    {
        $invoice = GovtTransactionInvoice::with('items')->where('invoice_number', $invoiceNumber)->firstOrFail();
        $html = view('govt_transactions.print', compact('invoice'))->render();
        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="'.$invoice->invoice_number.'.html"');
    }

    public function store(Request $request)
    {
        $rules = [
            'mohre_ref'           => 'required|string|max:255',
            'customer_type'       => 'required|string|in:Indoor,Walking',
            'customer_id'         => 'required|integer|exists:crms,id',
            'candidate_id'        => 'required_if:customer_type,Indoor|nullable|integer|exists:new_candidates,id',
            'invoice_date'        => 'required|date',
            'payment_mode'        => 'required|string|max:255',
            'payment_reference'   => 'nullable|string|max:255',
            'due_date'            => 'nullable|date',
            'discount_amount'     => 'nullable|numeric|min:0',
            'received_amount'     => 'nullable|numeric|min:0',
            'currency'            => 'required|string|max:10',
            'payment_proof'       => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',

            'service_name'        => 'required|array|min:1',
            'service_name.*'      => 'required|string|max:255',
            'dw_numbers'          => 'nullable|array',
            'dw_numbers.*'        => 'nullable|string|max:255',
            'quantities'          => 'required|array',
            'quantities.*'        => 'required|numeric|min:1',
            'rates'               => 'required|array',
            'rates.*'             => 'required|numeric|min:0',
            'taxes'               => 'required|array',
            'taxes.*'             => 'required|numeric|min:0',
            'center_fees'         => 'required|array',
            'center_fees.*'       => 'required|numeric|min:0',
        ];

        $messages = [
            'customer_id.exists'          => 'Selected customer was not found.',
            'candidate_id.required_if'    => 'Please select a candidate for Indoor customers.',
            'candidate_id.exists'         => 'Selected candidate was not found.',
            'payment_proof.required'      => 'Payment proof is required.',
            'payment_proof.mimes'         => 'Payment proof must be a JPG, JPEG, PNG, or PDF file.',
            'payment_proof.max'           => 'Payment proof must not exceed 5 MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($v) use ($request) {
            $counts = [
                count($request->input('service_name', [])),
                count($request->input('quantities', [])),
                count($request->input('rates', [])),
                count($request->input('taxes', [])),
                count($request->input('center_fees', [])),
            ];
            if (count(array_unique($counts)) !== 1) {
                $v->errors()->add('service_name', 'Invoice item rows are inconsistent. Please fill all fields for each row.');
            }
        });

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $splitVatIncl = function (float $amountIncl, float $taxPct): array {
            if ($taxPct <= 0) {
                return ['base' => $amountIncl, 'vat' => 0.0];
            }
            $base = $amountIncl / (1 + ($taxPct / 100));
            return ['base' => $base, 'vat' => $amountIncl - $base];
        };

        try {
            if (!$request->hasFile('payment_proof')) {
                throw ValidationException::withMessages(['payment_proof' => 'Payment proof is required.']);
            }

            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

            $customer  = CRM::findOrFail($request->customer_id);
            $candidate = null;

            if ($request->customer_type === 'Indoor') {
                if (!$request->filled('candidate_id')) {
                    throw ValidationException::withMessages(['candidate_id' => 'Please select a candidate for Indoor customers.']);
                }
                $candidate = NewCandidate::findOrFail($request->candidate_id);
            }

            if (empty($customer->first_name) && empty($customer->last_name)) {
                throw ValidationException::withMessages(['customer_id' => 'Selected customer does not have a name set.']);
            }
            if ($request->customer_type === 'Indoor' && empty($candidate->candidate_name)) {
                throw ValidationException::withMessages(['candidate_id' => 'Selected candidate does not have a name set.']);
            }

            $invoiceNumber = $this->nextInvoiceNumber();

            DB::transaction(function () use ($request, $splitVatIncl, $proofPath, $customer, $candidate, $invoiceNumber) {
                $invoice = GovtTransactionInvoice::create([
                    'invoice_number'     => $invoiceNumber,
                    'mohre_ref'          => $request->mohre_ref,
                    'invoice_date'       => $request->invoice_date,
                    'customer_type'      => $request->customer_type,
                    'CL_Number'          => $customer->CL_Number ?? null,
                    'Customer_name'      => trim(($customer->first_name ?? '').' '.($customer->last_name ?? '')),
                    'Customer_mobile_no' => $customer->mobile ?? $customer->phone ?? null,
                    'candidate_name'     => $candidate ? ($candidate->candidate_name ?? null) : null,
                    'CN_Number'          => $candidate ? ($candidate->CN_Number ?? null) : null,
                    'Sales_name'         => auth()->user()?->name,
                    'total_amount'       => 0,
                    'total_vat'          => 0,
                    'total_center_fee'   => 0,
                    'discount_amount'    => (float) $request->discount_amount,
                    'net_total'          => 0,
                    'received_amount'    => (float) $request->received_amount,
                    'remaining_amount'   => 0,
                    'status'             => 'Paid',
                    'currency'           => $request->currency,
                    'due_date'           => $request->due_date,
                    'payment_reference'  => $request->payment_reference,
                    'notes'              => $request->notes,
                    'payment_mode'       => $request->payment_mode,
                    'payment_proof'      => $proofPath,
                    'payment_note'       => $request->payment_note,
                    'created_by'         => auth()->id(),
                ]);

                $subtotal = 0.0;
                $vatTotal = 0.0;
                $centerInclTotal = 0.0;

                $rows = count($request->service_name);
                for ($i = 0; $i < $rows; $i++) {
                    $qty       = (float) $request->quantities[$i];
                    $rate      = (float) $request->rates[$i];
                    $taxPct    = (float) $request->taxes[$i];
                    $centerInc = (float) $request->center_fees[$i];

                    $amount = $qty * $rate;
                    $split  = $splitVatIncl($centerInc, $taxPct);
                    $base   = $split['base'];
                    $vat    = $split['vat'];
                    $total  = $amount + $base + $vat;

                    GovtTransactionInvoiceItem::create([
                        'invoice_number'   => $invoice->invoice_number,
                        'service_name'     => $request->service_name[$i],
                        'dw_number'        => $request->dw_numbers[$i] ?? null,
                        'qty'              => $qty,
                        'rate'             => $rate,
                        'amount'           => $amount,
                        'tax'              => $taxPct,
                        'center_fee_incl'  => $centerInc,
                        'center_fee_base'  => $base,
                        'center_fee_vat'   => $vat,
                        'total'            => $total,
                    ]);

                    $subtotal        += $amount + $base;
                    $vatTotal        += $vat;
                    $centerInclTotal += $centerInc;
                }

                $discount   = max((float) $request->discount_amount, 0.0);
                $gross      = $subtotal + $vatTotal;
                $grandTotal = max($gross - $discount, 0.0);
                $received   = max((float) $request->received_amount, 0.0);
                $remaining  = max($grandTotal - $received, 0.0);

                $invoice->update([
                    'total_amount'     => $subtotal,
                    'total_vat'        => $vatTotal,
                    'total_center_fee' => $centerInclTotal,
                    'net_total'        => $grandTotal,
                    'remaining_amount' => $remaining,
                ]);
            });

            return redirect()->route('govt-transactions.show', $invoiceNumber);

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (ModelNotFoundException $e) {
            return back()->withErrors(['general' => 'The selected customer/candidate was not found.'])->withInput();
        } catch (QueryException $e) {
            return back()->withErrors(['general' => 'Database error while saving the invoice.'])->withInput();
        } catch (Throwable $e) {
            return back()->withErrors(['general' => 'Unable to save invoice. Please try again.'])->withInput();
        }
    }

    protected function nextInvoiceNumber(): string
    {
        $prefix = now()->format('Ymd');
        $random = Str::upper(Str::random(4));
        return $prefix.'-'.$random;
    }
}
