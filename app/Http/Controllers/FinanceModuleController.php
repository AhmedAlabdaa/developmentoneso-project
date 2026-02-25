<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinanceModuleController extends Controller
{
    private function nowDubai(): string
    {
        return Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
    }

    public function index()
    {
        $now = $this->nowDubai();
        return view('finance_module.index', compact('now'));
    }

    public function journals(Request $request)
    {
        $q = DB::table('v_fin_journal_list');

        if ($request->filled('from')) $q->whereDate('journal_date', '>=', $request->from);
        if ($request->filled('to')) $q->whereDate('journal_date', '<=', $request->to);
        if ($request->filled('source_type')) $q->where('source_type', $request->source_type);
        if ($request->filled('ref')) $q->where('reference_no', 'like', '%' . trim($request->ref) . '%');

        $journals = $q->orderByDesc('journal_date')
            ->orderByDesc('journal_id')
            ->paginate(25)
            ->withQueryString();

        $now = $this->nowDubai();

        return view('finance_module.journals', compact('journals', 'now'));
    }

    public function journalEntries()
    {
        $now = $this->nowDubai();
        return view('finance_module.journal_entries', compact('now'));
    }

    public function journalShow($journalId)
    {
        $journal = \App\Models\JournalHeader::with(['lines.ledger', 'lines.employee', 'source', 'preSrc', 'creator'])
            ->findOrFail($journalId);

        $lines = $journal->lines;
        $now = $this->nowDubai();
        
        // Transform journal object slightly if needed to match view expectations (though view uses direct property access)
        // Adjust status to string if it's an Enum (or let blade handle it if cast)

        // For backward compatibility with the view expecting specific fields if they differ:
        $journal->journal_id = $journal->id; 
        $journal->journal_date = $journal->posting_date->format('Y-m-d');
        // $journal->reference_no mapped from meta_json or similar if needed. 
        // Note: JournalHeader model uses 'note', view might expect 'memo'.
        // Let's ensure the view handles this. I already updated the view to use $journal->note ?? $journal->memo.

        return view('finance_module.journal_show', compact('journal', 'lines', 'now'));
    }

    public function trialBalance(Request $request)
    {
        $now = $this->nowDubai();
        return view('finance_module.trial_balance', compact('now'));
    }

    public function openAr(Request $request)
    {
        $q = DB::table('v_fin_open_ar');

        if ($request->filled('customer')) {
            $q->where('customer_name', 'like', '%' . trim($request->customer) . '%');
        }

        $rows = $q->orderByDesc('open_balance')->paginate(50)->withQueryString();

        $now = $this->nowDubai();

        return view('finance_module.open_ar', compact('rows', 'now'));
    }

    public function customerLedger(Request $request)
    {
        $q = DB::table('v_fin_customer_ledger');

        if ($request->filled('from')) $q->whereDate('journal_date', '>=', $request->from);
        if ($request->filled('to')) $q->whereDate('journal_date', '<=', $request->to);
        if ($request->filled('crm_customer_id')) $q->where('crm_customer_id', $request->crm_customer_id);

        $rows = $q->orderBy('crm_customer_id')
            ->orderBy('journal_date')
            ->orderBy('journal_id')
            ->paginate(50)
            ->withQueryString();

        $customers = DB::table('acc_customer_map')
            ->selectRaw('crm_customer_id, CONCAT(customer_name," (",cl_number,")") as label')
            ->where('is_active', 1)
            ->orderBy('customer_name')
            ->get();

        $now = $this->nowDubai();

        return view('finance_module.customer_ledger', compact('rows', 'customers', 'now'));
    }

    public function employeeOca(Request $request)
    {
        $q = DB::table('v_fin_employee_oca_ledger');

        if ($request->filled('from')) $q->whereDate('journal_date', '>=', $request->from);
        if ($request->filled('to')) $q->whereDate('journal_date', '<=', $request->to);
        if ($request->filled('employee_id')) $q->where('employee_id', $request->employee_id);

        $rows = $q->orderBy('employee_id')
            ->orderBy('journal_date')
            ->orderBy('journal_id')
            ->paginate(50)
            ->withQueryString();

        $employees = DB::table('acc_employee_map')
            ->selectRaw('employee_id, CONCAT(employee_name," (",package_code,")") as label')
            ->where('is_active', 1)
            ->where('package_code', 'PKG-3')
            ->orderBy('employee_name')
            ->get();

        $now = $this->nowDubai();

        return view('finance_module.employee_oca', compact('rows', 'employees', 'now'));
    }

    public function vat(Request $request)
    {
        $rows = DB::table('v_fin_vat_summary')->paginate(24)->withQueryString();

        $now = $this->nowDubai();

        return view('finance_module.vat', compact('rows', 'now'));
    }

    public function vatDetail(Request $request)
    {
        $q = DB::table('v_fin_vat_detail');

        if ($request->filled('from')) $q->whereDate('journal_date', '>=', $request->from);
        if ($request->filled('to')) $q->whereDate('journal_date', '<=', $request->to);
        if ($request->filled('ref')) $q->where('reference_no', 'like', '%' . trim($request->ref) . '%');

        $rows = $q->orderByDesc('journal_date')->paginate(50)->withQueryString();

        $now = $this->nowDubai();

        return view('finance_module.vat_detail', compact('rows', 'now'));
    }

    public function errors()
    {
        $rows = DB::table('acc_posting_errors')->orderByDesc('id')->paginate(50);

        $now = $this->nowDubai();

        return view('finance_module.errors', compact('rows', 'now'));
    }

    public function statementOfAccount($ledgerId)
    {
        $now = $this->nowDubai();
        return view('finance_module.statement_of_account', compact('ledgerId', 'now'));
    }
}
