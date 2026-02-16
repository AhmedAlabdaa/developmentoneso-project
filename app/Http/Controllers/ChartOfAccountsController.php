<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccounts;
use App\Models\NewCandidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ChartOfAccountsController extends Controller
{
    public function index(Request $request)
    {
        $query = ChartOfAccounts::with('parentAccount');

        if ($request->filled('account_code')) {
            $query->where('account_code', 'like', '%' . trim($request->input('account_code')) . '%');
        }

        if ($request->filled('account_name')) {
            $query->where('account_name', 'like', '%' . trim($request->input('account_name')) . '%');
        }

        if ($request->filled('account_type')) {
            $query->where('account_type', strtoupper(trim($request->input('account_type'))));
        }

        $accounts = $query->orderByDesc(DB::raw('CAST(account_code AS UNSIGNED)'))->paginate(10);

        $parentAccounts = ChartOfAccounts::whereNull('parent_account_code')
            ->orderBy(DB::raw('CAST(account_code AS UNSIGNED)'))
            ->get();

        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        if ($request->ajax()) {
            return view('chart_of_accounts.partials.chart_of_accounts_table', compact(
                'accounts',
                'outsideAllNewCandidates',
                'now',
                'parentAccounts'
            ))->render();
        }

        return view('chart_of_accounts.index', compact(
            'accounts',
            'outsideAllNewCandidates',
            'now',
            'parentAccounts'
        ));
    }

    public function create()
    {
        $parentAccounts = ChartOfAccounts::orderBy(DB::raw('CAST(account_code AS UNSIGNED)'))->get();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('chart_of_accounts.create', compact('parentAccounts','now'));
    }

    public function show($id)
    {
        $account = ChartOfAccounts::with('parentAccount')->where('account_id', $id)->firstOrFail();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('chart_of_accounts.show', compact('account','now'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_code' => ['nullable', 'max:20', Rule::unique('coa_accounts', 'account_code')],
            'account_name' => ['required', 'string', 'max:200', Rule::unique('coa_accounts', 'account_name')],
            'parent_account_code' => ['nullable', 'max:20', 'exists:coa_accounts,account_code'],
            'account_type' => ['required', Rule::in(['ASSET','LIABILITY','EQUITY','INCOME','EXPENSE'])],
            'is_posting' => ['nullable', 'boolean'],
            'is_control' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $parentCode = $validated['parent_account_code'] ?? null;

        $account = DB::transaction(function () use ($validated, $parentCode) {
            $isControl = (int)($validated['is_control'] ?? 0);
            $isPosting = (int)($validated['is_posting'] ?? 1);
            if ($isControl === 1) $isPosting = 1;

            $accountCode = trim((string)($validated['account_code'] ?? ''));

            if ($accountCode === '') {
                $accountCode = (string)$this->generateAccountCode($parentCode);
            }

            $type = strtoupper($validated['account_type']);
            $normalBalance = in_array($type, ['ASSET','EXPENSE']) ? 'D' : 'C';

            return ChartOfAccounts::create([
                'account_code' => $accountCode,
                'account_name' => $validated['account_name'],
                'parent_account_code' => $parentCode,
                'account_type' => $type,
                'normal_balance' => $normalBalance,
                'is_posting' => $isPosting,
                'is_control' => $isControl,
                'currency_code' => 'AED',
                'is_active' => (int)($validated['is_active'] ?? 1),
                'sort_order' => (int)($validated['sort_order'] ?? 0),
            ]);
        });

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Account added successfully!', 'account' => $account], 201);
        }

        return redirect()->route('chart-of-accounts.index')->with('success', 'Account added successfully!');
    }

    public function edit($id)
    {
        $account = ChartOfAccounts::where('account_id', $id)->firstOrFail();
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $parentAccounts = ChartOfAccounts::where('account_code', '!=', $account->account_code)
            ->orderBy(DB::raw('CAST(account_code AS UNSIGNED)'))
            ->get();

        return view('chart_of_accounts.edit', compact('account', 'parentAccounts','now'));
    }

    public function update(Request $request, $id)
    {
        $account = ChartOfAccounts::where('account_id', $id)->firstOrFail();

        $validated = $request->validate([
            'account_code' => ['required', 'max:20', Rule::unique('coa_accounts', 'account_code')->ignore($account->account_id, 'account_id')],
            'account_name' => ['required', 'string', 'max:200', Rule::unique('coa_accounts', 'account_name')->ignore($account->account_id, 'account_id')],
            'parent_account_code' => ['nullable', 'max:20', 'exists:coa_accounts,account_code'],
            'account_type' => ['required', Rule::in(['ASSET','LIABILITY','EQUITY','INCOME','EXPENSE'])],
            'is_posting' => ['required', 'boolean'],
            'is_control' => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        $newParentCode = $validated['parent_account_code'] ?? null;

        if ($newParentCode !== null && $newParentCode === $validated['account_code']) {
            return back()->withErrors(['parent_account_code' => 'Parent account cannot be the same account.'])->withInput();
        }

        if ($newParentCode !== null && $this->wouldCreateCycle($validated['account_code'], $newParentCode)) {
            return back()->withErrors(['parent_account_code' => 'Invalid parent selection (cycle detected).'])->withInput();
        }

        $type = strtoupper($validated['account_type']);
        $normalBalance = in_array($type, ['ASSET','EXPENSE']) ? 'D' : 'C';

        $isControl = (int)$validated['is_control'];
        $isPosting = (int)$validated['is_posting'];
        if ($isControl === 1) $isPosting = 1;

        $account->update([
            'account_code' => $validated['account_code'],
            'account_name' => $validated['account_name'],
            'parent_account_code' => $newParentCode,
            'account_type' => $type,
            'normal_balance' => $normalBalance,
            'is_posting' => $isPosting,
            'is_control' => $isControl,
            'is_active' => (int)$validated['is_active'],
            'sort_order' => (int)($validated['sort_order'] ?? 0),
            'currency_code' => 'AED',
        ]);

        return redirect()->route('chart-of-accounts.index')->with('success', 'Account updated successfully');
    }

    public function destroy($id)
    {
        $account = ChartOfAccounts::where('account_id', $id)->firstOrFail();

        $hasChildren = ChartOfAccounts::where('parent_account_code', $account->account_code)->exists();
        if ($hasChildren) {
            return back()->withErrors(['delete' => 'Cannot delete an account that has child accounts.']);
        }

        $account->delete();

        return redirect()->route('chart-of-accounts.index')->with('success', 'Account deleted successfully');
    }

    private function generateAccountCode(?string $parentCode): int
    {
        return DB::transaction(function () use ($parentCode) {
            if ($parentCode !== null) {
                $parent = ChartOfAccounts::where('account_code', $parentCode)->lockForUpdate()->firstOrFail();
                $baseCode = (int)$parent->account_code;

                $lastSibling = ChartOfAccounts::where('parent_account_code', $parentCode)
                    ->lockForUpdate()
                    ->orderByDesc(DB::raw('CAST(account_code AS UNSIGNED)'))
                    ->first();

                return $lastSibling ? ((int)$lastSibling->account_code + 1) : ($baseCode + 1);
            }

            $lastTop = ChartOfAccounts::whereNull('parent_account_code')
                ->lockForUpdate()
                ->orderByDesc(DB::raw('CAST(account_code AS UNSIGNED)'))
                ->first();

            $last = $lastTop ? (int)$lastTop->account_code : 0;

            if ($last < 1000) return 1000;
            if ($last < 2000) return 2000;
            if ($last < 3000) return 3000;
            if ($last < 4000) return 4000;
            if ($last < 5000) return 5000;

            return $last + 1000;
        });
    }

    private function wouldCreateCycle(string $accountCode, string $newParentCode): bool
    {
        $current = $newParentCode;

        while ($current !== '') {
            if ($current === $accountCode) return true;

            $parent = ChartOfAccounts::where('account_code', $current)->value('parent_account_code');
            if ($parent === null) break;

            $current = (string)$parent;
        }

        return false;
    }
}
