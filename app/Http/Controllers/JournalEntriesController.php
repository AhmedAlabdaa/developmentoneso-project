<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;

class JournalEntriesController extends Controller
{
    public function index()
    {
        $journalEntries = JournalEntry::all();
        return view('journal_entries.index', compact('journalEntries'));
    }

    public function create()
    {
        return view('journal_entries.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        JournalEntry::create($validatedData);
        return redirect()->route('journal-entries.index')->with('success', 'Journal Entry created successfully.');
    }

    public function show($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        return view('journal_entries.show', compact('journalEntry'));
    }

    public function edit($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        return view('journal_entries.edit', compact('journalEntry'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->update($validatedData);
        return redirect()->route('journal-entries.index')->with('success', 'Journal Entry updated successfully.');
    }

    public function destroy($id)
    {
        $journalEntry = JournalEntry::findOrFail($id);
        $journalEntry->delete();
        return redirect()->route('journal-entries.index')->with('success', 'Journal Entry deleted successfully.');
    }
}
