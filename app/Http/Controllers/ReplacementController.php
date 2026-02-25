<?php

namespace App\Http\Controllers;

use App\Models\Replacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplacementController extends Controller
{
    public function index(Request $request)
    {
        $replacements = Replacement::query()->latest()->paginate(25);

        $replacementStatusStats = Replacement::query()
            ->selectRaw("LOWER(status) as st, COUNT(*) as c, COALESCE(SUM(refunded_amount),0) as a")
            ->groupBy('st')
            ->get()
            ->keyBy('st')
            ->map(fn($x) => ['count' => (int)$x->c, 'amount' => (float)$x->a])
            ->toArray();

        $replacementStatusStats = array_replace([
            'open' => ['count' => 0, 'amount' => 0],
            'closed' => ['count' => 0, 'amount' => 0],
            'cancelled' => ['count' => 0, 'amount' => 0],
        ], $replacementStatusStats);

        return view('replacements.index', compact('replacements', 'replacementStatusStats'));
    }

    public function viewForm(Replacement $replacement)
    {
        return view('replacements.view', compact('replacement'));
    }

    public function updateStatus(Request $request)
    {
        $v = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:replacements,id'],
            'status' => ['required', 'in:open,closed,cancelled'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $replacement = Replacement::findOrFail((int)$request->id);
        $replacement->status = $request->status;
        $replacement->save();

        return response()->json([
            'success' => true,
            'status' => $replacement->status,
            'message' => 'Replacement status updated.',
        ]);
    }
}
