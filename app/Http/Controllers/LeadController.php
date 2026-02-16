<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lead;
use Carbon\Carbon;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query();

        if ($request->filled('globalSearch')) {
            $search = '%' . $request->globalSearch . '%';
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', $search)
                  ->orWhere('last_name', 'like', $search)
                  ->orWhere('phone', 'like', $search)
                  ->orWhere('email', 'like', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('sales_name')) {
            $query->where('sales_name', 'like', '%' . $request->sales_name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        return view('leads.index', compact('leads', 'now'));
    }

    public function create()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('leads.create', compact('now'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email|unique:leads,email',
            'sales_name'  => 'nullable|string|max:255',
            'source'      => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'emirate'     => 'nullable|string|max:255', 
            'negotiation' => 'nullable|string|max:255',
            'notes'       => 'nullable|string|max:1000',
        ]);

        Lead::create($validatedData);

        return redirect()->route('leads.index')->with('success', 'Lead created successfully.');
    }

    public function show($id)
    {
        $lead = Lead::findOrFail($id);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        return view('leads.show', compact('lead', 'now'));
    }

    public function edit($id)
    {
        $lead = Lead::findOrFail($id);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

        return view('leads.edit', compact('lead', 'now'));
    }

    public function update(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'nullable|email|unique:leads,email,' . $id,
            'sales_name'  => 'nullable|string|max:255',
            'source'      => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'city'        => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'emirate'     => 'nullable|string|max:255', 
            'negotiation' => 'nullable|string|max:255',
            'notes'       => 'nullable|string|max:1000',
        ]);

        $lead->update($validatedData);

        return redirect()->route('leads.index')->with('success', 'Lead updated successfully.');
    }

    public function destroy($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();

        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully.');
    }
}
