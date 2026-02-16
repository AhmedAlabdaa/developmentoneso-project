<?php


namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\NewCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $query = Agent::query();

            if ($request->filled('agent_name')) {
                $query->where('name', 'LIKE', '%' . $request->agent_name . '%');
            }

            if ($request->filled('company_name')) {
                $query->where('company_name', 'LIKE', '%' . $request->company_name . '%');
            }

            if ($request->filled('branch_name')) {
                $query->where('branch_name', 'LIKE', '%' . $request->branch_name . '%');
            }

            if ($request->filled('country')) {
                $query->where('country', $request->country);
            }

            $agents = $query->paginate(10);

            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'html' => view('agents.partials.agents_table', compact('agents'))->render()
                ]);
            }

            return view('agents.index', compact('now', 'agents'));

        } catch (\Exception $e) {
            Log::error('Error fetching agents: ', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred while loading the agents.'], 500);
            }

            return response()->view('errors.500', ['message' => 'An error occurred while loading the agents.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:agents,name',
            'company_name' => 'required|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
        ]);

        try {
            $agent = Agent::create($validatedData);
            return response()->json($agent, 201);
        } catch (\Exception $e) {
            Log::error('Error creating agent: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create agent.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $agent = Agent::find($id);

            if (!$agent) {
                return response()->json(['error' => 'Agent not found'], 404);
            }

            return response()->json($agent);
        } catch (\Exception $e) {
            Log::error('Error fetching agent: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve agent.'], 500);
        }
    }

    public function edit($id)
    {
        try {
            $agent = Agent::find($id);

            if (!$agent) {
                return redirect()->route('agents.index')->withErrors(['msg' => 'Agent not found.']);
            }
            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
            $outsideAllNewCandidates = NewCandidate::where('current_status', 1)->count();
            return view('agents.edit', compact('agent' , 'now' ,'outsideAllNewCandidates'));
        } catch (\Exception $e) {
            Log::error('Error fetching agent for edit: ' . $e->getMessage());
            return redirect()->route('agents.index')->withErrors(['msg' => 'An error occurred while loading the agent.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $agent = Agent::find($id);

            if (!$agent) {
                return redirect()->route('agents.index')->with('error', 'Agent not found.');
            }

            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:agents,name,' . $id,
                'company_name' => 'required|string|max:255',
                'branch_name' => 'nullable|string|max:255',
                'country' => 'required|string|max:255',
            ]);

            $agent->update($validatedData);
            return redirect()->route('agents.index')->with('success', 'Agent updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating agent: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update agent. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $agent = Agent::find($id);

            if (!$agent) {
                return response()->json(['error' => 'Agent not found'], 404);
            }

            $agent->delete();
            return response()->json(['message' => 'Agent deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting agent: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete agent.'], 500);
        }
    }

    public function agent_commission(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $query = DB::table('agent_comission');

            if ($request->filled('agent_name')) {
                $query->where('agent_name', 'LIKE', '%' . $request->agent_name . '%');
            }

            if ($request->filled('cl_number')) {
                $query->where('cl_number', $request->cl_number);
            }

            if ($request->filled('cn_number')) {
                $query->where('cn_number', $request->cn_number);
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('incident_ref')) {
                $query->where('incident_no', 'LIKE', '%' . $request->incident_ref . '%');
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = Carbon::parse($request->from_date)->startOfDay();
                $toDate = Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            }

            $totalCredit = $query->sum('credit_amount');
            $totalDebit = $query->sum('debit_amount');

            $paginatedQuery = clone $query;
            $commissions = $paginatedQuery->paginate(10);

            $now = Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');

            if ($request->ajax()) {
                $html = view('agents.partials.agent_commission_table', compact('commissions', 'totalCredit', 'totalDebit', 'now'))->render();
                return response()->json([
                    'status' => 'success',
                    'html' => $html,
                ]);
            }

            return view('agents.agent_commission', compact('now', 'commissions', 'totalCredit', 'totalDebit'));

        } catch (\Exception $e) {
            Log::error('Error fetching agent commissions', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'An error occurred while loading the agent commissions.'], 500);
            }

            return response()->view('errors.500', ['message' => 'An error occurred while loading the agent commissions.'], 500);
        }
    }

}
