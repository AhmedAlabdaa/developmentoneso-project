<?php

namespace App\Http\Controllers;

use App\Queries\AmContractMovementQuery;
use App\Queries\AmInstallmentQuery;
use App\Services\AmContractMovementService;
use App\Services\AmInstallmentService;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use App\Models\AmContractMovment;
use Illuminate\Support\Facades\Log;

/**
 * @group Package 3 Modular
 * @subgroup Contract Movements
 *
 * APIs for managing contract movements.
 */
class AmContractMovementController extends Controller
{
    protected $query;
    protected $service;
    protected $installmentQuery;
    protected $installmentService;

    public function __construct(
        AmContractMovementQuery $query,
        AmContractMovementService $service,
        AmInstallmentQuery $installmentQuery,
        AmInstallmentService $installmentService
    ) {
        $this->query = $query;
        $this->service = $service;
        $this->installmentQuery = $installmentQuery;
        $this->installmentService = $installmentService;
    }

    /**
     * List contract movements.
     *
     * Returns a paginated list of contract movements with optional filters.
     * Each movement includes the related contract, customer, employee, installments, and return info.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam sort_by string Sort field (id, date, status, created_at). Default: date. Example: status
     * @queryParam sort_direction string Sort direction (asc, desc). Default: desc. Example: asc
     * @queryParam contract_id integer Filter by primary contract ID. Example: 1
     * @queryParam employee_id integer Filter by employee/maid ID. Example: 5
     * @queryParam employee_name string Filter by employee/maid name. Example: Maria
     * @queryParam customer_name string Filter by customer name (first or last). Example: Ahmed
     * @queryParam crm_id integer Filter by customer (CRM) ID. Example: 1
     * @queryParam status integer Filter by status (0 = inactive, 1 = active). Example: 1
     * @queryParam date_from string Filter movements from this date. Example: 2026-01-01
     * @queryParam date_to string Filter movements until this date. Example: 2026-12-31
     * @queryParam search string Search by note. Example: contract
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 3,
     *       "date": "2026-03-01",
     *       "am_contract_id": 1,
     *       "employee_id": 5,
     *       "status": 1,
     *       "primary_contract": { "crm": {} },
     *       "employee": {},
     *       "installments": [],
     *       "return_info": null
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function index(Request $request)
    {
        $movements = $this->query->getContractMovements(
            $request->only([
                'contract_id',
                'employee_id',
                'employee_name',
                'customer_name',
                'crm_id',
                'status',
                'date_from',
                'date_to',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            $request->input('per_page', 15)
        );

        return response()->json($movements);
    }


    /**
     * Display a specific contract movement.
     *
     * Returns a single contract movement with its related contract, customer, employee, installments, and return info.
     *
     * @urlParam id integer required The contract movement ID. Example: 3
     *
     * @response 200 {
     *   "id": 3,
     *   "date": "2026-03-01",
     *   "am_contract_id": 1,
     *   "employee_id": 5,
     *   "status": 1,
     *   "primary_contract": { "crm": {} },
     *   "employee": {},
     *   "installments": [],
     *   "return_info": null
     * }
     * @response 404 {
     *   "message": "Contract movement not found",
     *   "error": "Error message"
     * }
     */
    public function show($id)
    {
        try {
            $movement = $this->query->getById($id);
            return response()->json($movement);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Contract movement not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update a contract movement.
     *
     * @urlParam id integer required The contract movement ID. Example: 3
     * @bodyParam date string The movement date. Example: 2026-04-01
     * @bodyParam employee_id integer The employee/maid ID. Example: 5
     * @bodyParam note string An optional note. Example: Updated assignment
     * @bodyParam note string An optional note. Example: Updated assignment
     * @bodyParam installments array[] List of installments to create or update.
     * @bodyParam installments[].id integer Optional. The installment ID to update. If omitted, a new installment will be created. Example: 16
     * @bodyParam installments[].amount number required_without:installments[].id. The installment amount. Example: 1500
     * @bodyParam installments[].date string Optional. The installment date. Example: 2026-04-01
     * @bodyParam installments[].note string Optional. An optional note for the installment. Example: Monthly payment
     *     *
     * @response 200 {
     *   "message": "Contract movement updated successfully",
     *   "data": {}
     * }
     * @response 404 {
     *   "message": "Contract movement not found",
     *   "error": "Error message"
     * }
     * @response 500 {
     *   "message": "Failed to update contract movement",
     *   "error": "Error message"
     * }
     */
    public function update(Request $request, $id)
    {
        // Pre-process dates to ensure they are in Y-m-d format for validation and database
        if ($request->has('date') && $request->date) {
            try {
                $request->merge(['date' => Carbon::parse($request->date)->format('Y-m-d')]);
            } catch (\Exception $e) {
                // Let validation handle the invalid date format
            }
        }

        if ($request->has('installments') && is_array($request->installments)) {
            $installments = $request->installments;
            foreach ($installments as $key => $inst) {
                if (isset($inst['date']) && $inst['date']) {
                    try {
                        $installments[$key]['date'] = Carbon::parse($inst['date'])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Let validation handle
                    }
                }
            }
            $request->merge(['installments' => $installments]);
        }

        $request->validate([
            'date' => 'sometimes|date',
            'employee_id' => 'sometimes|integer|exists:employees,id',
            'note' => 'nullable|string',
            'installments' => 'nullable|array',
            'installments.*.id' => 'sometimes|integer|exists:am_installments,id',
            'installments.*.amount' => 'required_without:installments.*.id|numeric|min:0',
            'installments.*.date' => 'sometimes|date',
            'installments.*.note' => 'nullable|string',
        ]);

        try {
            $movement = $this->query->getById($id);
            $updated = $this->service->update($movement, $request->all());

            return response()->json([
                'message' => 'Contract movement updated successfully',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Contract movement not found' : 'Failed to update contract movement',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete a contract movement.
     *
     * @urlParam id integer required The contract movement ID. Example: 3
     *
     * @response 200 {
     *   "message": "Contract movement deleted successfully"
     * }
     * @response 404 {
     *   "message": "Contract movement not found",
     *   "error": "Error message"
     * }
     * @response 500 {
     *   "message": "Failed to delete contract movement",
     *   "error": "Error message"
     * }
     */
    public function destroy($id)
    {
        try {
            $movement = $this->query->getById($id);
            $this->service->delete($movement);

            return response()->json([
                'message' => 'Contract movement deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Contract movement not found' : 'Failed to delete contract movement',
                'error' => $e->getMessage(),
            ], $status);
        }
    }


    public function getMinistryContract(Request $request, $contractId)
    {

        Log::info("Fetching ministry contract for contract ID: {$contractId}");
        $cont = AmContractMovment::with(['employee', 'primaryContract.crm'])->findorFail($contractId);

        return view('monthly_contracts/ministry_contract', compact('cont'));
        
    }


}
