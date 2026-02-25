<?php

namespace App\Http\Controllers;

use App\Models\CRM;
use App\Models\PaymentReceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentReceiptController extends Controller
{
    private const CREATE_ROLES = ['Accountant', 'Cashier', 'Finance Officer','Admin'];
    private const APPROVE_ROLES = ['Finance Officer','Admin'];

    private function jsonFail(int $code, string $message, array $errors = [])
    {
        throw new HttpResponseException(
            response()->json(
                array_filter(['success' => false, 'message' => $message, 'errors' => $errors]),
                $code
            )
        );
    }

    private function requireRole(Request $r, array $roles): void
    {
        $u = auth()->user();
        if (!$u || !in_array($u->role, $roles, true)) {
            if ($r->expectsJson()) $this->jsonFail(403, 'Forbidden');
            abort(403);
        }
    }

    private function ensurePayer(Request $r, array $data): void
    {
        $t = $data['payer_type'] ?? null;
        $cid = $data['customer_id'] ?? null;
        $win = trim((string)($data['walkin_name'] ?? ''));

        $ok =
            ($t === 'customer' && !empty($cid) && $win === '') ||
            ($t === 'walkin' && empty($cid) && $win !== '');

        if (!$ok) {
            if ($r->expectsJson()) $this->jsonFail(422, 'Choose Customer OR Walk-in');
            abort(422, 'Choose Customer OR Walk-in');
        }
    }

    private function storeRules(): array
    {
        return [
            'receipt_date' => ['required', 'date'],
            'payer_type' => ['required', Rule::in(['customer', 'walkin'])],
            'customer_id' => ['nullable', 'integer', 'min:1', Rule::exists('crm', 'id')],
            'walkin_name' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['required', 'string', 'max:1000'],
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ];
    }

    private function updateRules(): array
    {
        return [
            'receipt_date' => ['required', 'date'],
            'payer_type' => ['required', Rule::in(['customer', 'walkin'])],
            'customer_id' => ['nullable', 'integer', 'min:1', Rule::exists('crm', 'id')],
            'walkin_name' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'string', 'max:100'],
            'reference_no' => ['nullable', 'string', 'max:255'],
            'notes' => ['required', 'string', 'max:1000'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
        ];
    }

    public function index()
    {
        $receipts = PaymentReceipt::with('customer')->orderByDesc('id')->get();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('payment-receipts.index', compact('receipts', 'now'));
    }

    public function customersSearch(Request $r)
    {
        $q = trim((string)$r->get('q', ''));

        $rows = CRM::query()
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%")
                    ->orWhereRaw("CONCAT(COALESCE(first_name,''),' ',COALESCE(last_name,'')) LIKE ?", ["%{$q}%"]);
            })
            ->orderBy('first_name')
            ->limit(20)
            ->get(['id', 'first_name', 'last_name']);

        $results = $rows->map(function ($c) {
            $name = trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? ''));
            if ($name === '') $name = 'Customer';
            return ['id' => $c->id, 'text' => $name . ' (ID: ' . $c->id . ')'];
        })->values();

        return response()->json(['results' => $results]);
    }

    public function store(Request $r)
    {
        $this->requireRole($r, self::CREATE_ROLES);

        $data = $r->validate($this->storeRules());
        $this->ensurePayer($r, $data);

        $receipt = DB::transaction(function () use ($r, $data) {
            $prefix = 'PR-';

            $max = PaymentReceipt::where('receipt_number', 'like', "{$prefix}%")
                ->lockForUpdate()
                ->max(DB::raw("CAST(SUBSTRING(receipt_number, " . (strlen($prefix) + 1) . ") AS UNSIGNED)"));

            $next = ((int)$max) + 1;
            $number = $prefix . str_pad((string)$next, 5, '0', STR_PAD_LEFT);

            $path = $r->file('attachment')->store('payment_receipts', 'public');

            return PaymentReceipt::create([
                'receipt_number' => $number,
                'receipt_date' => $data['receipt_date'],
                'payer_type' => $data['payer_type'],
                'customer_id' => $data['payer_type'] === 'customer' ? $data['customer_id'] : null,
                'walkin_name' => $data['payer_type'] === 'walkin' ? trim((string)$data['walkin_name']) : null,
                'amount' => $data['amount'],
                'payment_method' => $data['payment_method'],
                'reference_no' => $data['reference_no'] ?? null,
                'notes' => $data['notes'],
                'attachment_path' => $path,
                'status' => 'Pending',
                'created_by' => auth()->id(),
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Payment receipt created', 'data' => $receipt->load('customer')], 201);
    }

    public function update(Request $r, PaymentReceipt $payment_receipt)
    {
        $this->requireRole($r, self::CREATE_ROLES);

        if ($payment_receipt->status !== 'Pending') {
            return response()->json(['success' => false, 'message' => 'Only Pending receipts can be updated'], 422);
        }

        $data = $r->validate($this->updateRules());
        $this->ensurePayer($r, $data);

        DB::transaction(function () use ($r, $data, $payment_receipt) {
            if ($r->hasFile('attachment')) {
                if ($payment_receipt->attachment_path && Storage::disk('public')->exists($payment_receipt->attachment_path)) {
                    Storage::disk('public')->delete($payment_receipt->attachment_path);
                }
                $payment_receipt->attachment_path = $r->file('attachment')->store('payment_receipts', 'public');
            }

            $payment_receipt->receipt_date = $data['receipt_date'];
            $payment_receipt->payer_type = $data['payer_type'];
            $payment_receipt->customer_id = $data['payer_type'] === 'customer' ? $data['customer_id'] : null;
            $payment_receipt->walkin_name = $data['payer_type'] === 'walkin' ? trim((string)$data['walkin_name']) : null;
            $payment_receipt->amount = $data['amount'];
            $payment_receipt->payment_method = $data['payment_method'];
            $payment_receipt->reference_no = $data['reference_no'] ?? null;
            $payment_receipt->notes = $data['notes'];
            $payment_receipt->save();
        });

        return response()->json(['success' => true, 'message' => 'Payment receipt updated', 'data' => $payment_receipt->fresh()->load('customer')]);
    }

    public function destroy(Request $r, PaymentReceipt $payment_receipt)
    {
        $this->requireRole($r, self::APPROVE_ROLES);

        if ($payment_receipt->status !== 'Pending') {
            return response()->json(['success' => false, 'message' => 'Only Pending receipts can be deleted'], 422);
        }

        DB::transaction(function () use ($payment_receipt) {
            if ($payment_receipt->attachment_path && Storage::disk('public')->exists($payment_receipt->attachment_path)) {
                Storage::disk('public')->delete($payment_receipt->attachment_path);
            }
            $payment_receipt->delete();
        });

        return response()->json(['success' => true, 'message' => 'Payment receipt deleted']);
    }

    public function status(Request $r, PaymentReceipt $payment_receipt)
    {
        $this->requireRole($r, self::APPROVE_ROLES);

        $data = $r->validate([
            'status' => ['required', Rule::in(['Pending', 'Approved', 'Cancelled'])],
            'cancel_reason' => ['nullable', 'string', 'max:2000'],
        ]);

        $to = $data['status'];

        if ($to === 'Approved') {
            if ($payment_receipt->status !== 'Pending') {
                return response()->json(['success' => false, 'message' => 'Only Pending receipts can be approved'], 422);
            }

            $payment_receipt->status = 'Approved';
            $payment_receipt->approved_by = auth()->id();
            $payment_receipt->approved_at = Carbon::now();
            $payment_receipt->cancelled_by = null;
            $payment_receipt->cancelled_at = null;
            $payment_receipt->cancel_reason = null;
            $payment_receipt->save();

            return response()->json(['success' => true, 'message' => 'Receipt approved', 'data' => $payment_receipt->fresh()->load('customer')]);
        }

        if ($to === 'Cancelled') {
            $payment_receipt->status = 'Cancelled';
            $payment_receipt->cancelled_by = auth()->id();
            $payment_receipt->cancelled_at = Carbon::now();
            $payment_receipt->cancel_reason = $data['cancel_reason'] ?? null;
            $payment_receipt->save();

            return response()->json(['success' => true, 'message' => 'Receipt cancelled', 'data' => $payment_receipt->fresh()->load('customer')]);
        }

        $payment_receipt->status = 'Pending';
        $payment_receipt->approved_by = null;
        $payment_receipt->approved_at = null;
        $payment_receipt->cancelled_by = null;
        $payment_receipt->cancelled_at = null;
        $payment_receipt->cancel_reason = null;
        $payment_receipt->save();

        return response()->json(['success' => true, 'message' => 'Status updated', 'data' => $payment_receipt->fresh()->load('customer')]);
    }
}
