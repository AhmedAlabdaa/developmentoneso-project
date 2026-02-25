<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\NewCandidate;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IncidentsController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::query()->orderBy('id', 'desc');
        if ($request->filled('incident_category')) {
            $query->where('incident_category', 'like', '%' . $request->input('incident_category') . '%');
        }

        if ($request->filled('candidate_name')) {
            $query->where('candidate_name', 'like', '%' . $request->input('candidate_name') . '%');
        }

        if ($request->filled('employer_name')) {
            $query->where('employer_name', 'like', '%' . $request->input('employer_name') . '%');
        }

        if ($request->filled('candidate_reference_no')) {
            $query->where('candidate_reference_no', 'like', '%' . $request->input('candidate_reference_no') . '%');
        }

        if ($request->filled('candidate_nationality')) {
            $query->where('candidate_nationality', $request->input('candidate_nationality'));
        }

        if ($request->filled('candidate_passport_number')) {
            $query->where('candidate_passport_number', 'like', '%' . $request->input('candidate_passport_number') . '%');
        }

        if ($request->filled('incident_reason')) {
            $query->where('incident_reason', 'like', '%' . $request->input('incident_reason') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $incidents = $query->paginate(10);
        $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();

        if ($request->ajax()) {
            return view('incidents.partials.incidents_table', compact('incidents'));
        }
        return view('incidents.index', compact('incidents', 'now', 'outsideAllNewCandidates'));
    }
    public function show($id)
    {
        $incident = Incident::findOrFail($id);
        return response()->json($incident);
    }

}
