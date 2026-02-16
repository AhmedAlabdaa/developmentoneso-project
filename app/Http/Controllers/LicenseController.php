<?php

namespace App\Http\Controllers;

use App\Models\License;
use App\Models\NewCandidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
        $licensesQuery = License::with('uploadedByUser')->orderBy('id', 'desc');
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $licensesQuery->where('expiry_date', $request->input('status') === 'valid' ? '>' : '<', Carbon::now('Asia/Dubai'));
        }
        if ($request->filled('document_type')) {
            $licensesQuery->where('document_type', $request->input('document_type'));
        }
        if ($request->filled('license_id')) {
            $licensesQuery->where('id', $request->input('license_id'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $licensesQuery->where(function ($q) use ($search) {
                $q->where('file_name', 'LIKE', "%{$search}%")
                  ->orWhere('document_number', 'LIKE', "%{$search}%");
            });
        }
        $licenses = $licensesQuery->paginate(10);
        return $request->ajax()
            ? view('licenses.partials.license_table', compact('licenses', 'now', 'outsideAllNewCandidates'))
            : view('licenses.index', compact('licenses', 'now', 'outsideAllNewCandidates'));
    }

    public function create()
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('licenses.create', compact('now'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'file_name' => 'required|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,avi,mov',
            'document_type' => 'required|string',
            'document_number' => 'required|string|unique:licenses,document_number',
            'document_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:document_date',
            'renewal_required' => 'required|in:Yes,No',
        ]);
        $validated['renewal_required'] = $validated['renewal_required'] === 'Yes' ? 1 : 0;
        $path = $request->file('file')->store('licenses', 'public');
        $validated['file'] = basename($path);
        $validated['file_path'] = 'licenses/' . basename($path);
        $validated['status'] = now()->lessThanOrEqualTo(Carbon::parse($validated['expiry_date'])) ? 'Valid' : 'Expired';
        $validated['uploaded_by'] = Auth::id();
        try {
            License::create($validated);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'License could not be created. ' . $e->getMessage());
        }
        return redirect()->route('licenses.index')->with('success', 'License created successfully.');
    }

    public function show(License $license)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('licenses.show', compact('license', 'now'));
    }

    public function edit(License $license)
    {
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('licenses.edit', compact('license', 'now'));
    }

    public function update(Request $request, License $license)
    {
        $validated = $request->validate([
            'file_name' => 'required|string',
            'file' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,avi,mov',
            'document_type' => 'required|string',
            'document_number' => 'required|string|unique:licenses,document_number,' . $license->id,
            'document_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:document_date',
            'renewal_required' => 'required|in:Yes,No',
        ]);
        $validated['renewal_required'] = $validated['renewal_required'] === 'Yes' ? 1 : 0;
        if ($request->hasFile('file')) {
            if ($license->file_path && Storage::disk('public')->exists($license->file_path)) {
                Storage::disk('public')->delete($license->file_path);
            }
            $path = $request->file('file')->store('licenses', 'public');
            $validated['file'] = basename($path);
            $validated['file_path'] = 'licenses/' . basename($path);
        }
        $validated['status'] = now()->lessThanOrEqualTo(Carbon::parse($validated['expiry_date'])) ? 'Valid' : 'Expired';
        $validated['uploaded_by'] = Auth::id();
        $license->update($validated);
        return redirect()->route('licenses.index')->with('success', 'License updated successfully.');
    }

    public function destroy(License $license)
    {
        if ($license->file_path && Storage::disk('public')->exists($license->file_path)) {
            Storage::disk('public')->delete($license->file_path);
        }
        $license->delete();
        return redirect()->route('licenses.index')->with('success', 'License deleted successfully.');
    }
}
