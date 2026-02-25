<?php

namespace App\Http\Controllers;

use App\Services\ReturnMaid\AmReturnMaidService;
use App\Queries\AmReturnMaidQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

/**
 * @group Package 3 Modular
 * @subgroup Return Maids
 *
 * this will return namespace App\Enum;
  *enum MCStatus: int
   * case Pending = 0;
  *case ReturnToOffice = 1;
  *Amer make this status to show in return list if value 0 make it pending and if value 1 make it return to office
  *in the raw action I want to make action for refund or replacement or due amount
   
 */
class AmReturnMaidController extends Controller
{
    protected $service;
    protected $query;

    public function __construct(AmReturnMaidService $service, AmReturnMaidQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * Return a maid from a contract movement.
     *
     * Records the return in am_return_maids, sets movement and contract status to 0,
     * and resets the maid's inside_status back to 1 (in office).
     *
     * @urlParam id integer required The contract movement ID. Example: 3
     * @bodyParam date string required The return date. Example: 2026-02-19
     * @bodyParam note string An optional note. Example: Maid returned by customer
     * @bodyParam status integer Return status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: 1
     * @bodyParam action integer Return action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: 1
     *
     * @response 200 {
     *   "message": "Maid returned successfully",
     *   "data": {}
     * }
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {}
     * }
     * @response 500 {
     *   "message": "Failed to return maid",
     *   "error": "Error message"
     * }
     */
    public function returnContract(Request $request, $id)
    {
        $input = $request->all();
        if (isset($input['date'])) {
            try {
                $input['date'] = \Carbon\Carbon::parse($input['date'])->format('Y-m-d');
            } catch (\Exception $e) {
                // Let validation handle invalid date
            }
        }

        $validator = Validator::make($input, [
            'date' => 'required|date',
            'note' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1,2,3,4',
            'action' => 'nullable|integer|in:1,2,3,4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $movement = $this->query->getMovmentById($id);
            $updatedMovement = $this->service->returnContract($movement, $validator->validated());

            return response()->json([
                'message' => 'Maid returned successfully',
                'data'    => $updatedMovement,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to return maid',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mark returned maid as replacement requested and execute replacement.
     *
     * @urlParam id integer required The return maid ID. Example: 1
     * @bodyParam new_employee_id integer required New employee ID for replacement. Example: 5
     * @bodyParam date string Replacement date. Example: 2026-02-22
     *
     * @response 200 {
     *   "message": "Replacement executed successfully",
     *   "data": {}
     * }
     */
    public function executeReplacement(Request $request, $id)
    {
        $validated = $request->validate([
            'new_employee_id' => 'required|integer|exists:employees,id',
            'date' => 'nullable|date|after_or_equal:today',
        ]);

        try {
            $returnMaid = $this->query->getById($id);
            $replacement = $this->service->replaceReturnedMaid($returnMaid, $validated);

            return response()->json([
                'message' => 'Replacement executed successfully',
                'data' => $replacement,
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Return maid record not found' : 'Failed to execute replacement',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * List return maids.
     *
     * Returns a paginated list of maid returns with optional filters.
     * Each return includes the related contract movement, employee, contract, and customer.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam sort_by string Sort field (id, date, status, created_at). Default: date. Example: status
     * @queryParam sort_direction string Sort direction (asc, desc). Default: desc. Example: asc
     * @queryParam contract_id integer Filter by primary contract ID. Example: 1
     * @queryParam employee_id integer Filter by employee/maid ID. Example: 5
     * @queryParam employee_name string Filter by employee/maid name. Example: Maria
     * @queryParam customer_name string Filter by customer name (first or last). Example: Ahmed
     * @queryParam crm_id integer Filter by customer (CRM) ID. Example: 1
     * @queryParam status integer Filter by status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: 1
     * @queryParam action integer Filter by action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: 1
     * @queryParam date_from string Filter returns from this date. Example: 2026-01-01
     * @queryParam date_to string Filter returns until this date. Example: 2026-12-31
     * @queryParam search string Search by note. Example: returned
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 1,
     *       "date": "2026-02-19",
     *       "am_movment_id": 3,
     *       "note": "Maid returned by customer",
     *       "status": 1,
     *       "contract_movment": {
     *         "id": 3,
     *         "employee": {},
     *         "primary_contract": { "crm": {} }
     *       }
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function returnMaids(Request $request)
    {
        $returnMaids = $this->query->getReturnMaids(
            $request->only([
                'contract_id',
                'employee_id',
                'employee_name',
                'customer_name',
                'crm_id',
                'status',
                'action',
                'date_from',
                'date_to',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            $request->input('per_page', 15)
        );

        return response()->json($returnMaids);
    }

    /**
     * Display a specific return maid record.
     *
     * Returns a single return maid with its related contract movement, employee, and customer.
     *
     * @urlParam id integer required The return maid ID. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "date": "2026-02-19",
     *   "am_movment_id": 3,
     *   "note": "Maid returned by customer",
     *   "status": 1,
     *   "contract_movment": {}
     * }
     * @response 404 {
     *   "message": "Return maid record not found",
     *   "error": "Error message"
     * }
     */
    public function show($id)
    {
        try {
            $returnMaid = $this->query->getById($id);
            return response()->json($returnMaid);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Return maid record not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update a return maid record.
     *
     * @urlParam id integer required The return maid ID. Example: 1
     * @bodyParam date string The return date. Example: 2026-02-20
     * @bodyParam note string An optional note. Example: Updated return note
     * @bodyParam status integer Status (0 = Pending, 1 = Return to Office, 2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: 1
     * @bodyParam action integer Action (1 = Pending, 2 = Replacement, 3 = Refund, 4 = Due Amount). Example: 1
     *
     * @response 200 {
     *   "message": "Return maid record updated successfully",
     *   "data": {}
     * }
     * @response 404 {
     *   "message": "Return maid record not found",
     *   "error": "Error message"
     * }
     * @response 500 {
     *   "message": "Failed to update return maid record",
     *   "error": "Error message"
     * }
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'sometimes|date',
            'note' => 'nullable|string',
            'status' => 'nullable|integer|in:0,1,2,3,4',
            'action' => 'nullable|integer|in:1,2,3,4',
        ]);

        try {
            $returnMaid = $this->query->getById($id);
            $this->service->updateReturn($returnMaid, $request->all());

            return response()->json([
                'message' => 'Return maid record updated successfully',
                'data' => $returnMaid->refresh()->load(['contractMovment.primaryContract.crm', 'contractMovment.employee']),
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Return maid record not found' : 'Failed to update return maid record',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete a return maid record.
     *
     * @urlParam id integer required The return maid ID. Example: 1
     *
     * @response 200 {
     *   "message": "Return maid record deleted successfully"
     * }
     * @response 404 {
     *   "message": "Return maid record not found",
     *   "error": "Error message"
     * }
     * @response 500 {
     *   "message": "Failed to delete return maid record",
     *   "error": "Error message"
     * }
     */
    public function destroy($id)
    {
        try {
            $returnMaid = $this->query->getById($id);
            $this->service->deleteReturn($returnMaid);

            return response()->json([
                'message' => 'Return maid record deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Return maid record not found' : 'Failed to delete return maid record',
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
