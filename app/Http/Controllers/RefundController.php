<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
    public function index(Request $request)
    {
        $query = Refund::query();

        if ($request->filled('status')) {
            $status = $this->normStatus($request->string('status')->toString());
            $query->where('status', $status);
        }

        if ($request->filled('reference_no')) {
            $query->where('reference_no', 'like', '%' . $request->string('reference_no')->toString() . '%');
        }

        if ($request->filled('candidate_name')) {
            $query->where('candidate_name', 'like', '%' . $request->string('candidate_name')->toString() . '%');
        }

        if ($request->filled('passport_no')) {
            $query->where('passport_no', 'like', '%' . $request->string('passport_no')->toString() . '%');
        }

        $refunds = $query->orderByDesc('id')->paginate(15)->withQueryString();

        $refundStatusStats = [
            'open' => $this->statusAgg('open'),
            'closed' => $this->statusAgg('closed'),
            'cancelled' => $this->statusAgg('cancelled'),
        ];

        return view('package.refunds.index', compact('refunds', 'refundStatusStats'));
    }

    public function view($id)
    {
        $refund = Refund::query()->findOrFail($id);

        return view('package.refunds.view', compact('refund'));
    }

    public function updateStatus(Request $request)
    {
        $user = Auth::user();
        $role = $user->role ?? '';

        $allowedRoles = ['Admin', 'Operations Manager', 'Managing Director', 'Accountant', 'Cashier', 'Finance Officer'];
        if (!in_array($role, $allowedRoles, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized.',
            ], 403);
        }

        $v = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:refunds,id'],
            'status' => ['required', 'string', 'in:open,closed,cancelled,canceled'],
        ]);

        if ($v->fails()) {
            return response()->json([
                'success' => false,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $id = (int) $request->input('id');
        $status = $this->normStatus((string) $request->input('status'));

        $refund = Refund::query()->findOrFail($id);
        $refund->status = $status;
        $refund->updated_by_sales_name = $user->name ?? $user->username ?? $user->email ?? $refund->updated_by_sales_name;
        $refund->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated.',
            'status' => $refund->status,
        ]);
    }

    private function normStatus(string $v): string
    {
        $v = strtolower(trim($v));
        if ($v === 'canceled') {
            return 'cancelled';
        }
        return $v !== '' ? $v : 'open';
    }

    private function statusAgg(string $status): array
    {
        $status = $this->normStatus($status);

        $q = Refund::query()->where('status', $status);

        return [
            'count' => (int) $q->count(),
            'amount' => (float) $q->sum('refunded_amount'),
        ];
    }
}
