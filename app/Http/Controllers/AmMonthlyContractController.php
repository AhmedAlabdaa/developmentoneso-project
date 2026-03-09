<?php

namespace App\Http\Controllers;

use App\Enum\EnumMaidStatus;
use App\Imports\AmMonthlyContractsImport;
use App\Services\AmMonthlyContractService;
use App\Queries\AmMonthlyContractQuery;
use App\Http\Requests\StoreAmMonthlyContractRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @group Package 3 Modular
 * @subgroup Primary contract p3
 */
class AmMonthlyContractController extends Controller
{
    protected $service;
    protected $query;

    public function __construct(AmMonthlyContractService $service, AmMonthlyContractQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List all monthly contracts.
     *
     * Returns a paginated list of monthly contracts with movements, installments, employee and customer data.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam customer_name string Filter by customer name (first or last). Example: Ahmed
     * @queryParam crm_id integer Filter by customer (CRM) ID. Example: 1
     * @queryParam employee_name string Filter by employee/maid name. Example: Maria
     * @queryParam employee_id integer Filter by employee/maid ID. Example: 5
     * @queryParam status integer Filter by status (0 = inactive, 1 = active). Example: 1
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 0
     * }
     */
    public function index(Request $request)
    {
        $contracts = $this->query->getAllContracts(
            $request->only([
                'customer_name',
                'crm_id',
                'employee_name',
                'employee_id',
                'status',
            ]),
            $request->input('per_page', 15)
        );
        return response()->json($contracts);
    }


    /**
     * Create a new monthly contract.
     *
     * Creates a primary contract with a contract movement and installments.
     * Optionally creates a prorate journal entry when prorate_amount is provided.
     *
     * @bodyParam start_date string required The contract start date. Example: 2026-03-01
     * @bodyParam ended_date string The contract end date. Example: 2027-03-01
     * @bodyParam customer_id integer required The customer (CRM) ID. Example: 1
     * @bodyParam maid_id integer required The employee/maid ID. Example: 5
     * @bodyParam installment array required List of installments.
     * @bodyParam installment[].date string required The installment date. Example: 2026-03-01
     * @bodyParam installment[].amount number required The installment amount. Example: 1000
     * @bodyParam installment[].note string A note for the installment. Example: First installment
     * @bodyParam prorate_amount number The prorate amount (VAT inclusive). When provided, a journal entry is created splitting the amount into VAT, salary cost, and profit. Example: 3000
     * @bodyParam prorate_days integer Number of prorate days (1-30, required when prorate_amount is provided). Example: 24
     *
     * @response 201 {
     *   "message": "Contract created successfully",
     *   "data": {}
     * }
     * @response 422 {
     *   "message": "Prorate amount is less than maid salary.",
     *   "errors": {"prorate_amount": ["Prorate base amount (X) is less than maid salary cost (Y)."]}
     * }
     * @response 500 {
     *   "message": "Failed to create contract",
     *   "error": "Error message"
     * }
     */
    public function store(StoreAmMonthlyContractRequest $request)
    {
        try {
            $contract = $this->service->createContract($request->validated());

            return response()->json([
                'message' => 'Contract created successfully',
                'data' => $contract
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display a specific monthly contract.
     *
     * Returns a single contract with its movements, installments, employee and customer data.
     *
     * @urlParam id integer required The contract ID. Example: 1
     *
     * @response 200 {
     *   "id": 1,
     *   "date": "2026-03-01",
     *   "crm_id": 1,
     *   "end_date": "2027-03-01",
     *   "status": 1,
     *   "type": 2,
     *   "contract_movments": [],
     *   "crm": {}
     * }
     * @response 404 {
     *   "message": "Contract not found",
     *   "error": "Error message"
     * }
     */
    public function show($id)
    {
        try {
            $contract = $this->query->getContractById($id);
            return response()->json($contract);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Contract not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    /**
     * Update a monthly contract.
     *
     * @urlParam id integer required The contract ID. Example: 1
     * @bodyParam date string The contract start date. Example: 2026-04-01
     * @bodyParam end_date string The contract end date. Example: 2027-04-01
     * @bodyParam note string An optional note. Example: Updated contract note
     *
     * @response 200 {
     *   "message": "Contract updated successfully",
     *   "data": {}
     * }
     * @response 404 {
     *   "message": "Contract not found",
     *   "error": "Error message"
     * }
     * @response 500 {
     *   "message": "Failed to update contract",
     *   "error": "Error message"
     * }
     */
    public function update(Request $request, $id)
    {
        // Convert empty string to null for end_date, and parse dates to Y-m-d
        $data = $request->all();
        
        if (isset($data['date']) && $data['date'] !== '') {
            try {
                $data['date'] = \Carbon\Carbon::parse($data['date'])->format('Y-m-d');
            } catch (\Exception $e) {}
        }
        
        if (isset($data['end_date']) && $data['end_date'] === '') {
            $data['end_date'] = null;
        } elseif (isset($data['end_date']) && $data['end_date'] !== null) {
            try {
                $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->format('Y-m-d');
            } catch (\Exception $e) {}
        }
        
        $request->merge([
            'date' => $data['date'] ?? null,
            'end_date' => $data['end_date'] ?? null
        ]);

        $request->validate([
            'date' => 'sometimes|date',
            'end_date' => 'sometimes|nullable|date',
            'note' => 'nullable|string',
        ]);

        try {
            $contract = $this->query->getContractById($id);
            $updatedContract = $this->service->updateContract($contract, $request->only(['date', 'end_date', 'note']));

            return response()->json([
                'message' => 'Contract updated successfully',
                'data' => $updatedContract
            ]);

        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Contract not found' : 'Failed to update contract',
                'error' => $e->getMessage()
            ], $status);
        }
    }

    /**
     * Delete a monthly contract.
     *
     * Deletes the contract and its associated movements and installments.
     *
     * @urlParam id integer required The contract ID. Example: 1
     *
     * @response 200 {
     *   "message": "Contract deleted successfully"
     * }
     * @response 500 {
     *   "message": "Failed to delete contract",
     *   "error": "Error message"
     * }
     */
    public function destroy($id)
    {
        try {
            $contract = $this->query->getContractById($id);
            $this->service->deleteContract($contract);

            return response()->json([
                'message' => 'Contract deleted successfully'
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete contract',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Lookup employees (maids).
     *
     * Search employees by name for autocomplete. Returns id and name only.
     *
     * @queryParam search string Search term to match against maid name. Example: maria
     * @queryParam limit integer Maximum number of results. Default: 20. Example: 10
     *
     * @response 200 [
     *   {
     *     "id": 5,
     *     "name": "Maria Santos"
     *   },
     *   {
     *     "id": 12,
     *     "name": "Maria Garcia"
     *   }
     * ]
     */
    public function lookupEmployee(Request $request)
    {
        $employees = $this->query->lookupEmployees(
            $request->input('search'),
            $request->input('limit', 20)
        );

        return response()->json($employees);
    }

    /**
     * List employees (maids).
     *
     * Returns a paginated list of employees with optional filters.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam name string Filter by employee name. Example: maria
     * @queryParam inside_status integer Filter by inside status (1 = Office, 4 = Hired). Example: 1
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 5,
     *       "name": "Maria Santos",
     *       "inside_status": 1
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function employees(Request $request)
    {
        $employees = $this->query->getEmployees(
            $request->only(['name', 'inside_status']),
            $request->input('per_page', 15)
        );

        return response()->json($employees);
    }

    /**
     * List all employees (maids).
     *
     * Returns a paginated list of employees with optional filters.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam name string Filter by employee name. Example: maria
     * @queryParam inside_status integer Filter by maid status enum:
     * 0 = Pending, 1 = Office, 2 = Hired, 3 = Incidented. Example: 1
     * @queryParam nationality string Filter by nationality. Example: Philippines
     * @queryParam payment_type string Filter by payment type. Example: bank
     * @queryParam passport_no string Filter by passport number (partial match). Example: P12345
     * @queryParam emirates_id string Filter by Emirates ID (partial match). Example: 784-
     * @queryParam reference_no string Filter by reference number (partial match). Example: EMP-0001
     * @queryParam inside_country_or_outside integer Filter by location status (1 = Outside, 2 = Inside). Example: 1
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 5,
     *       "name": "Maria Santos"
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function allEmployees(Request $request)
    {
        $allowedStatuses = array_map(
            static fn (EnumMaidStatus $status) => $status->value,
            EnumMaidStatus::cases()
        );

        $request->validate([
            'name' => 'nullable|string',
            'inside_status' => ['nullable', 'integer', Rule::in($allowedStatuses)],
            'nationality' => 'nullable|string|max:100',
            'payment_type' => 'nullable|string|max:50',
            'passport_no' => 'nullable|string|max:100',
            'emirates_id' => 'nullable|string|max:100',
            'reference_no' => 'nullable|string|max:100',
            'inside_country_or_outside' => ['nullable', 'integer', Rule::in([1, 2])],
            'per_page' => 'nullable|integer|min:1|max:200',
        ]);

        $employees = $this->query->getallEmployees(
            $request->only([
                'name',
                'inside_status',
                'nationality',
                'payment_type',
                'passport_no',
                'emirates_id',
                'reference_no',
                'inside_country_or_outside',
            ]),
            $request->input('per_page', 15)
        );

        return response()->json($employees);
    }

    /**
     * Lookup all employees (maids).
     *
     * Search all employees by name for autocomplete. Returns id and name only.
     *
     * @queryParam search string Search term to match against employee name. Example: maria
     * @queryParam limit integer Maximum number of results. Default: 20. Example: 10
     *
     * @response 200 [
     *   {
     *     "id": 5,
     *     "name": "Maria Santos"
     *   },
     *   {
     *     "id": 12,
     *     "name": "Maria Garcia"
     *   }
     * ]
     */
    public function lookupAllEmployees(Request $request)
    {
        $employees = $this->query->lookupAllEmployees(
            $request->input('search'),
            $request->input('limit', 20)
        );

        return response()->json($employees);
    }

    /**
     * Import monthly contracts from Excel.
     *
     * Expected heading columns:
     * - customer (CL_Number from CRM table)
     * - maid
     * - start
     * - end
     * - amount
     * - date_of_installment
     *
     * Validation:
     * - customer CL_Number must exist in CRM table
     * - maid must exist in Employees table
     *
     * Creates:
     * 1) am_primary_contracts
     * 2) am_contract_movments
     * 3) am_installments
     *
     * @bodyParam file file required Excel file (.xlsx/.xls/.csv) with heading row.
     *
     * @response 200 {
     *   "message": "Import completed",
     *   "contracts_created": 3,
     *   "row_failures_count": 1,
     *   "row_errors": [
     *     {"row": 4, "error": "Customer not found: Unknown"}
     *   ]
     * }
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt|max:10240',
        ]);

        $import = new AmMonthlyContractsImport($this->service);
        Excel::import($import, $request->file('file'));

        return response()->json([
            'message' => 'Import completed',
            'contracts_created' => $import->getContractsCreated(),
            'row_failures_count' => count($import->getErrors()),
            'row_errors' => $import->getErrors(),
        ]);
    }

    /**
     * Lookup customers (CRM).
     *
     * Search customers by name, mobile, or CL number for autocomplete.
     * Returns CRM IDs (not ledger IDs). Same response format as /api/ledgers/lookup-customers.
     *
     * @queryParam search string Search by name, mobile, CL number. Example: ahmed
     * @queryParam page integer Page number. Example: 1
     * @queryParam per_page integer Items per page. Default: 10. Example: 20
     *
     * @response 200 {
     *   "results": [
     *     {
     *       "id": 5,
     *       "text": "Ahmed Ali",
     *       "mobile": "0501234567",
     *       "crm": {
     *         "first_name": "Ahmed",
     *         "last_name": "Ali",
     *         "mobile": "0501234567",
     *         "CL_Number": "CL-001"
     *       }
     *     }
     *   ],
     *   "pagination": {
     *     "more": false,
     *     "current_page": 1,
     *     "total": 1
     *   }
     * }
     */
    public function lookupCustomer(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = min($request->input('per_page', 10), 50);

        $customers = $this->query->lookupCustomers($search, $perPage);

        // Format for Select2 — same structure as /api/ledgers/lookup-customers
        $results = $customers->map(function ($crm) {
            $name = trim(($crm->first_name ?? '') . ' ' . ($crm->last_name ?? ''));
            $displayName = $name ?: ($crm->ledger_name ?? 'Unknown');

            return [
                'id'     => $crm->id,
                'text'   => $displayName,
                'mobile' => $crm->mobile,
                'crm'    => [
                    'first_name' => $crm->first_name,
                    'last_name'  => $crm->last_name,
                    'mobile'     => $crm->mobile,
                    'CL_Number'  => $crm->CL_Number,
                ],
            ];
        });

        return response()->json([
            'results'    => $results,
            'pagination' => [
                'more'         => $customers->hasMorePages(),
                'current_page' => $customers->currentPage(),
                'total'        => $customers->total(),
            ],
        ]);
    }
}
