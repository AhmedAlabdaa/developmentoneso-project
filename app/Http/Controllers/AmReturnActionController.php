<?php

namespace App\Http\Controllers;

use App\Services\ReturnMaid\AmReturnMaidService;
use Illuminate\Http\Request;
use Exception;

/**
 * @group Package 3 Modular
 * @subgroup Return Actions
 *
 * APIs for managing actions on returned maids (Refund, Replacement, etc).
 */
class AmReturnActionController extends Controller
{
    protected AmReturnMaidService $service;

    public function __construct(AmReturnMaidService $service)
    {
        $this->service = $service;
    }

    /**
     * Ameeeeeeeeer this one make it on action return list maid as action for each row 
     * and aslo make same one it the insident return list maid.
     *
     * @urlParam id integer required The return maid ID. Example: 1
     * @bodyParam action integer required The action to set (1 = Pending, 2 = ReplacementRequested, 3 = RefundRaised, 4 = DueAmountOnCustomer). Example: 2
     *
     * @response 200 {
     *   "message": "Action updated successfully",
     *   "data": {
     *     "id": 1,
     *     "action": 2
     *   }
     * }
     * @response 404 {
     *   "message": "Return maid record not found"
     * }
     */
    public function updateAction(Request $request, $id)
    {
        $validated = $request->validate([
            'action' => 'required|integer|in:3',
            'amount' => 'required_if:action,3|numeric|min:0',
            'refund_date' => 'required_if:action,3|date',
            'note' => 'required_if:action,3|string',
        ]);

        try {
            $updatedReturn = $this->service->raiseRefundByReturnMaidId((int) $id, (int) $validated['action'], $validated);

            return response()->json([
                'message' => 'Action updated successfully',
                'data' => $updatedReturn,
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') || str_contains($e->getMessage(), 'not found') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Return maid record not found' : 'Failed to update action',
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
