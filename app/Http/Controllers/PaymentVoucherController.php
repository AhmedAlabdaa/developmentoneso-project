<?php

namespace App\Http\Controllers;

use App\Models\PaymentVoucher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\JournalHeaderService;
use App\Enum\JournalStatus;
use App\Models\LedgerOfAccount;
use Illuminate\Support\Facades\Log;

class PaymentVoucherController extends Controller
{
    const VNO_PREFIX = 'ALB-PV-';
    const VNO_PAD = 3;

    public function __construct(protected JournalHeaderService $journalHeaderService)
    {
    }

    protected function guard()
    {
        $role = Auth::user()->role ?? null;
        if (!in_array($role, ['Accountant', 'Cashier', 'Finance Officer', 'Admin'])) {
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['ok' => false, 'message' => 'Not authorized.'], 403);
            }
            abort(403);
        }
        return null;
    }

    public function index()
    {
        if ($r = $this->guard()) return $r;
        $now = $this->now();
        $vouchers = PaymentVoucher::with('journal.lines.ledger')->orderByDesc('id')->paginate(10);
        return view('payment_voucher.index', compact('vouchers', 'now'));
    }

    public function store(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $now = $this->now();

        [$ok, $dataOrErrors] = $this->validated($request, null, 'store');
        if (!$ok) {
            return response()->json(['ok' => false, 'errors' => $dataOrErrors, 'now' => $now], 422);
        }

        //  Log::info($request->all());

        try {
            $pv = DB::transaction(function () use ($request, $dataOrErrors) {
                // 1. Create Payment Voucher (excluding line data)
                $payload = $dataOrErrors['pv_payload'];
                $payload['voucher_no'] = $this->nextVoucherNo();
                $payload['status'] = 'Pending';
                $payload['created_by'] = Auth::id();
                $payload['approved_by'] = null;
                $payload['approved_at'] = null;
                $payload['cancelled_by'] = null;
                $payload['cancelled_at'] = null;
                $payload['attachments'] = $this->storeAttachments($request);
                $payload['lines_json'] = []; // Placeholder to satisfy DB constraint
                
                $pv = PaymentVoucher::create($payload);

                // 2. Create Journal Header
                $journal = $pv->journal()->create([
                    'posting_date' => $payload['voucher_date'],
                    'status' => JournalStatus::Draft,
                    'total_debit' => $dataOrErrors['totals']['debit'],
                    'total_credit' => $dataOrErrors['totals']['credit'],
                    'note' => $payload['narration'],
                    'created_by' => Auth::id(),
                ]);

                // 3. Create Journal Lines
                foreach ($dataOrErrors['lines'] as $line) {
                    $journal->lines()->create([
                        'ledger_id' => $line['ledger_id'],
                        'debit' => $line['debit'],
                        'credit' => $line['credit'],
                        'note' => $line['note'] ?? '',
                        'created_by' => Auth::id(),
                    ]);
                }

                return $pv;
            }, 3);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return response()->json(['ok' => false, 'message' => 'Failed to save voucher: ' . $e->getMessage(), 'now' => $now], 500);
        }

        return response()->json([
            'ok' => true,
            'id' => $pv->id,
            'voucher_no' => $pv->voucher_no,
            'message' => 'Voucher saved successfully.',
            'now' => $now,
        ]);
    }

    public function update(Request $request, PaymentVoucher $payment_voucher)
    {
        if ($r = $this->guard()) return $r;
        $now = $this->now();

        if ($payment_voucher->status !== 'Pending' && (Auth::user()->role ?? null) !== 'Finance Officer') {
            return response()->json(['ok' => false, 'message' => 'Only Finance Officer can modify non-pending vouchers.', 'now' => $now], 422);
        }

        [$ok, $dataOrErrors] = $this->validated($request, $payment_voucher->id, 'update');
        if (!$ok) {
            return response()->json(['ok' => false, 'errors' => $dataOrErrors, 'now' => $now], 422);
        }

        try {
            DB::transaction(function () use ($request, $payment_voucher, $dataOrErrors) {
                // 1. Update Payment Voucher
                $newAttachments = $this->storeAttachments($request);
                $existing = is_array($payment_voucher->attachments) ? $payment_voucher->attachments : [];
                $merged = array_values(array_filter(array_merge($existing, $newAttachments)));

                $payload = $dataOrErrors['pv_payload'];
                $payment_voucher->update(array_merge($payload, ['attachments' => $merged]));

                // 2. Update/Create Journal Header
                $journal = $payment_voucher->journal;
                if (!$journal) {
                    $journal = $payment_voucher->journal()->create([
                        'posting_date' => $payload['voucher_date'],
                        'status' => JournalStatus::Draft,
                        'total_debit' => $dataOrErrors['totals']['debit'],
                        'total_credit' => $dataOrErrors['totals']['credit'],
                        'note' => $payload['narration'],
                        'created_by' => Auth::id(),
                    ]);
                } else {
                    $journal->update([
                        'posting_date' => $payload['voucher_date'],
                        'note' => $payload['narration'],
                        'total_debit' => $dataOrErrors['totals']['debit'],
                        'total_credit' => $dataOrErrors['totals']['credit'],
                    ]);
                }

                // 3. Sync Lines (Delete all and recreate is safest/easiest)
                $journal->lines()->delete();
                foreach ($dataOrErrors['lines'] as $line) {
                    $journal->lines()->create([
                        'ledger_id' => $line['ledger_id'],
                        'debit' => $line['debit'],
                        'credit' => $line['credit'],
                        'note' => $line['note'] ?? '',
                        'created_by' => Auth::id(),
                    ]);
                }
            }, 3);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => 'Failed to update voucher: ' . $e->getMessage(), 'now' => $now], 500);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Voucher updated successfully.',
            'now' => $now,
        ]);
    }

    public function destroy(PaymentVoucher $payment_voucher)
    {
        if ($r = $this->guard()) return $r;
        $now = $this->now();

        if ($payment_voucher->status !== 'Pending' && (Auth::user()->role ?? null) !== 'Finance Officer') {
            return response()->json(['ok' => false, 'message' => 'Only Finance Officer can delete non-pending vouchers.', 'now' => $now], 422);
        }

        $payment_voucher->delete();

        return response()->json([
            'ok' => true,
            'message' => 'Voucher deleted.',
            'now' => $now,
        ]);
    }

    public function status(Request $request, PaymentVoucher $payment_voucher)
    {
        if ($r = $this->guard()) return $r;
        $now = $this->now();

        if ((Auth::user()->role ?? null) !== 'Finance Officer') {
            return response()->json(['ok' => false, 'message' => 'Not authorized.', 'now' => $now], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['Pending', 'Approved', 'Cancelled'])],
        ]);

        if ($validator->fails()) {
            return response()->json(['ok' => false, 'errors' => $validator->errors()->toArray(), 'now' => $now], 422);
        }

        $to = $request->string('status')->toString();

        if ($payment_voucher->status === $to) {
            return response()->json(['ok' => true, 'message' => 'Status unchanged.', 'now' => $now]);
        }

        $updates = ['status' => $to];

        if ($to === 'Approved') {
            $updates['approved_by'] = Auth::id();
            $updates['approved_at'] = Carbon::now('Asia/Dubai');
            $updates['cancelled_by'] = null;
            $updates['cancelled_at'] = null;
        } elseif ($to === 'Cancelled') {
            $updates['cancelled_by'] = Auth::id();
            $updates['cancelled_at'] = Carbon::now('Asia/Dubai');
            $updates['approved_by'] = null;
            $updates['approved_at'] = null;
        } else {
            $updates['approved_by'] = null;
            $updates['approved_at'] = null;
            $updates['cancelled_by'] = null;
            $updates['cancelled_at'] = null;
        }

        $payment_voucher->update($updates);

        return response()->json([
            'ok' => true,
            'message' => "Status updated to {$to}.",
            'now' => $now,
        ]);
    }

    protected function validated(Request $request, $id = null, string $mode = 'store'): array
    {
        $rules = [
            'voucher_date' => ['required', 'date_format:Y-m-d'],
            'payee' => ['required', 'string', 'max:191'],
            'mode_of_payment' => ['required', 'string', 'max:191'],
            'reference_no' => ['nullable', 'string', 'max:191'],
            'narration' => ['nullable', 'string'],
            'total_debit' => ['required', 'numeric', 'min:0'],
            'total_credit' => ['required', 'numeric', 'min:0'],
            'lines_json' => ['required'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp,gif,doc,docx,xls,xlsx,csv,txt', 'max:10240'],
        ];

        if ($mode === 'update') {
            $rules['voucher_no'] = ['sometimes', 'string', 'max:191', Rule::unique('payment_vouchers', 'voucher_no')->ignore($id)];
        }

        $messages = [
            'voucher_date.required' => 'Date is required.',
            'voucher_date.date_format' => 'Date must be in YYYY-MM-DD format.',
            'payee.required' => 'Payee is required.',
            'mode_of_payment.required' => 'Mode of Payment is required.',
            'total_debit.required' => 'Total Debit is required.',
            'total_credit.required' => 'Total Credit is required.',
            'lines_json.required' => 'At least one line is required.',
        ];

        $base = Validator::make($request->all(), $rules, $messages);
        if ($base->fails()) {
            return [false, $base->errors()->toArray()];
        }

        $linesRaw = $request->input('lines_json');
        if (is_string($linesRaw)) {
            $decoded = json_decode($linesRaw, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [false, ['lines_json' => ['Lines payload is not valid JSON.']]];
            }
            $lines = $decoded;
        } elseif (is_array($linesRaw)) {
            $lines = $linesRaw;
        } else {
            return [false, ['lines_json' => ['Lines payload must be an array or JSON string.']]];
        }

        if (!is_array($lines) || count($lines) < 1) {
            return [false, ['lines_json' => ['Add at least one line.']]];
        }

        $lineErrors = [];
        $sumDr = 0.0;
        $sumCr = 0.0;
        $processedLines = [];

        foreach ($lines as $i => $line) {
            $idx = $i + 1;
            // The frontend sends the ledger ID in the 'account' field for Select2
            $ledgerId = $line['account'] ?? null; 
            
            if (!$ledgerId) {
                $lineErrors["lines_json.$i.account"][] = "Line $idx: account is required.";
            }

            $debit = (float)($line['debit'] ?? 0);
            $credit = (float)($line['credit'] ?? 0);

            if (!is_numeric($debit) || $debit < 0) {
                 $lineErrors["lines_json.$i.debit"][] = "Line $idx: debit must be a number ≥ 0.";
            }
            if (!is_numeric($credit) || $credit < 0) {
                 $lineErrors["lines_json.$i.credit"][] = "Line $idx: credit must be a number ≥ 0.";
            }

            if ($debit > 0 && $credit > 0) {
                 $lineErrors["lines_json.$i"][] = "Line $idx: cannot have both debit and credit.";
            }
            if ($debit == 0 && $credit == 0) {
                 $lineErrors["lines_json.$i"][] = "Line $idx: enter either debit or credit.";
            }

            $sumDr += $debit;
            $sumCr += $credit;
            
            $processedLines[] = [
                'ledger_id' => $ledgerId,
                'debit' => $debit,
                'credit' => $credit,
                'note' => '', 
            ];
        }

        if (!empty($lineErrors)) {
            return [false, $lineErrors];
        }

        $calcDr = round($sumDr, 2);
        $calcCr = round($sumCr, 2);
        
        if (abs($calcDr - $calcCr) >= 0.01) {
            return [false, ['balance' => ["Lines are not balanced: Debit {$calcDr} vs Credit {$calcCr}."]]];
        }

        $totDr = round((float)$request->input('total_debit'), 2);
        $totCr = round((float)$request->input('total_credit'), 2);
        
        if (abs($totDr - $calcDr) >= 0.01 || abs($totCr - $calcCr) >= 0.01) {
            return [false, ['totals' => ['Header totals do not match line totals.']]];
        }

        $isoDate = Carbon::createFromFormat('Y-m-d', $request->input('voucher_date'), 'Asia/Dubai')->startOfDay()->toDateString();

        $pvPayload = [
            'voucher_date' => $isoDate,
            'payee' => $request->input('payee'),
            'mode_of_payment' => $request->input('mode_of_payment'),
            'reference_no' => $request->input('reference_no') ?: null,
            'narration' => $request->input('narration') ?: null,
            // lines_json is purposely omitted
            'total_debit' => $calcDr,
            'total_credit' => $calcCr,
        ];

        return [true, [
            'pv_payload' => $pvPayload,
            'lines' => $processedLines,
            'totals' => ['debit' => $calcDr, 'credit' => $calcCr]
        ]];
    }

    protected function nextVoucherNo(): string
    {
        $prefix = self::VNO_PREFIX;
        $pad = self::VNO_PAD;

        $maxNum = DB::table('payment_vouchers')
            ->where('voucher_no', 'like', $prefix . '%')
            ->lockForUpdate()
            ->pluck('voucher_no')
            ->reduce(function ($carry, $vno) use ($prefix) {
                if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $vno, $m)) {
                    $n = (int)$m[1];
                    return max($carry, $n);
                }
                return $carry;
            }, 0);

        $next = $maxNum + 1;
        return $prefix . str_pad((string)$next, $pad, '0', STR_PAD_LEFT);
    }

    protected function storeAttachments(Request $request): array
    {
        $files = $request->file('attachments', []);
        if (!$files) return [];
        $saved = [];
        foreach ($files as $file) {
            if (!$file || !$file->isValid()) continue;
            $path = $file->store('pv_attachments', 'public');
            if ($path) $saved[] = Storage::disk('public')->url($path);
        }
        return $saved;
    }

    protected function now(): string
    {
        return Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
    }
}
