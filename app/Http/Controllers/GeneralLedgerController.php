<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralLedger;

class GeneralLedgerController extends Controller
{
    public function index()
    {
        $generalLedgers = GeneralLedger::all();
        return view('general_ledger.index', compact('generalLedgers'));
    }

    public function create()
    {
        return view('general_ledger.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'account_name' => 'required|string|max:255',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric',
            'date' => 'required|date',
        ]);

        GeneralLedger::create($validatedData);
        return redirect()->route('general-ledger.index')->with('success', 'General Ledger entry created successfully.');
    }

    public function show($id)
    {
        $generalLedger = GeneralLedger::findOrFail($id);
        return view('general_ledger.show', compact('generalLedger'));
    }

    public function edit($id)
    {
        $generalLedger = GeneralLedger::findOrFail($id);
        return view('general_ledger.edit', compact('generalLedger'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'account_name' => 'required|string|max:255',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $generalLedger = GeneralLedger::findOrFail($id);
        $generalLedger->update($validatedData);
        return redirect()->route('general-ledger.index')->with('success', 'General Ledger entry updated successfully.');
    }

    public function destroy($id)
    {
        $generalLedger = GeneralLedger::findOrFail($id);
        $generalLedger->delete();
        return redirect()->route('general-ledger.index')->with('success', 'General Ledger entry deleted successfully.');
    }
}
