<?php

namespace App\Http\Controllers;

use App\Exports\LedgerOfAccountExport;
use App\Http\Requests\StoreLedgerRequest;
use App\Http\Resources\LedgerOfAccountResource;
use App\Services\LedgerOfAccountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @group Ledger of Accounts
 *
 * APIs for managing ledger accounts with filtering, sorting, and pagination.
 */
class LedgerOfAccountController extends Controller
{
    protected LedgerOfAccountService $ledgerService;

    public function __construct(LedgerOfAccountService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    /**
     * Display the ledger accounts management page
     *
     * @return \Illuminate\View\View
     */
    public function viewIndex()
    {
        $now = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        return view('ledgers.index', compact('now'));
    }

    /**
     * List all ledger accounts
     *
     * Get a paginated list of ledger accounts with optional filtering and sorting.
     *
     * @queryParam per_page integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by. Example: name
     * @queryParam sort_direction string Sort direction (asc or desc). Example: asc
     * @queryParam name string Filter by name (partial match). Example: Cash
     * @queryParam class integer Filter by class. Example: 1
     * @queryParam sub_class integer Filter by sub-class. Example: 1
     * @queryParam group string Filter by group. Example: Assets
     * @queryParam spacial integer Filter by spacial. Example: 1
     * @queryParam type string Filter by type (dr or cr). Example: dr
     * @queryParam created_by integer Filter by creator user ID. Example: 1
     * @queryParam created_from date Filter from date (Y-m-d). Example: 2025-01-01
     * @queryParam created_to date Filter to date (Y-m-d). Example: 2026-01-31
     * @queryParam search string Search across name, group, and note. Example: cash
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // Extract query parameters
        $filters = $request->only([
            'name', 'class', 'sub_class', 'group', 'spacial', 
            'type', 'created_by', 'created_from', 'created_to', 'search'
        ]);

        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $ledgers = $this->ledgerService->getPaginatedLedgers(
            $filters,
            (int) $perPage,
            $sortBy,
            $sortDirection
        );

        return LedgerOfAccountResource::collection($ledgers);
    }

    /**
     * Create a new ledger account
     *
     * Store a newly created ledger account in the database.
     *
     * @bodyParam name string required The name of the ledger account. Example: Cash Account
     * @bodyParam class integer required The class of the ledger account. Example: 1
     * @bodyParam sub_class integer required The sub-class of the ledger account. Example: 0
     * @bodyParam group string optional The group. Example: Assets
     * @bodyParam spacial integer required Spacial value. Example: 0
     * @bodyParam type string required The type (dr or cr). Example: dr
     * @bodyParam note string optional Additional notes. Example: Main cash account
     *
     * @param StoreLedgerRequest $request
     * @return JsonResponse
     */
    public function store(StoreLedgerRequest $request): JsonResponse
    {
        $ledger = $this->ledgerService->createLedger($request->validated());

        return (new LedgerOfAccountResource($ledger))
            ->additional([
                'success' => true,
                'message' => 'Ledger account created successfully',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a specific ledger account
     *
     * Display the details of a specific ledger account.
     *
     * @urlParam id integer required The ID of the ledger account. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $ledger = $this->ledgerService->getLedgerById($id);

        if (!$ledger) {
            return response()->json([
                'success' => false,
                'message' => 'Ledger account not found',
            ], 404);
        }

        return new LedgerOfAccountResource($ledger);
    }

    /**
     * Update a ledger account
     *
     * Update the details of a specific ledger account.
     *
     * @urlParam id integer required The ID of the ledger account. Example: 1
     * @bodyParam name string required The name of the ledger account. Example: Updated Cash Account
     * @bodyParam class integer required The class of the ledger account. Example: 1
     * @bodyParam sub_class integer required The sub-class of the ledger account. Example: 0
     * @bodyParam group string optional The group. Example: Assets
     * @bodyParam spacial integer required Spacial value. Example: 0
     * @bodyParam type string required The type (dr or cr). Example: dr
     * @bodyParam note string optional Additional notes. Example: Updated notes
     *
     * @param StoreLedgerRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreLedgerRequest $request, int $id)
    {
        $ledger = $this->ledgerService->updateLedger($id, $request->validated());

        if (!$ledger) {
            return response()->json([
                'success' => false,
                'message' => 'Ledger account not found',
            ], 404);
        }

        return (new LedgerOfAccountResource($ledger))
            ->additional([
                'success' => true,
                'message' => 'Ledger account updated successfully',
            ]);
    }

    /**
     * Delete a ledger account
     *
     * Remove a specific ledger account from the database.
     *
     * @urlParam id integer required The ID of the ledger account to delete. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->ledgerService->deleteLedger($id);

            if (!$deleted) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ledger account not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ledger account deleted successfully',
            ], 200);
        } catch (\DomainException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 409);
        }
    }

    /**
     * Lookup ledger accounts for dropdowns
     *
     * Get a simplified list of ledger accounts optimized for Select2/dropdown menus.
     * Returns format: {id, text, type, group}
     *
     * @queryParam search string Search by account name. Example: Cash
     * @queryParam type string Filter by type (dr or cr). Example: dr
     * @queryParam group string Filter by group. Example: Assets
     * @queryParam spacial integer Filter by spacial. Example: 3
     * @queryParam customer boolean Filter for customers (spacial=3). Example: true
     * @queryParam page integer Page number for pagination. Example: 1
     * @queryParam per_page integer Items per page (max 50). Example: 20
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function lookup(Request $request): JsonResponse
    {
        $search = $request->input('search', '');
        $type = $request->input('type');
        $group = $request->input('group');
        $spacial = $request->input('spacial');
        $perPage = min($request->input('per_page', 10), 50); // Max 50 items, default 10
        
        $query = \App\Models\LedgerOfAccount::query();
        
        // Search by name
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Filter by type
        if ($type) {
            $query->where('type', $type);
        }
        
        // Filter by group
        if ($group) {
            $query->where('group', $group);
        }

        // Filter by spacial
        if (!is_null($spacial)) {
            $query->where('spacial', $spacial);
        }

        // Filter by customer convenience param
        if ($request->has('customer')) {
            $query->where('spacial', 3);
        }
        
        // Order by name
        $query->orderBy('name', 'asc');
        
        // Paginate
        $ledgers = $query->paginate($perPage);
        
        // Format for Select2
        $results = $ledgers->map(function ($ledger) {
            return [
                'id' => $ledger->id,
                'text' => $ledger->name,
                'type' => $ledger->type,
                'group' => $ledger->group,
            ];
        });
        
        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $ledgers->hasMorePages(),
                'current_page' => $ledgers->currentPage(),
                'total' => $ledgers->total(),
            ]
        ]);
    }

    /**
     * Lookup customers with CRM search
     *
     * Specialized lookup for customers that searches in CRM fields (mobile, etc).
     *
     * @queryParam search string Search by name, mobile, CL number. Example: 0501234567
     * @queryParam page integer Page number. Example: 1
     * @queryParam per_page integer Items per page. Example: 20
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function lookupCustomer(Request $request): JsonResponse
    {
        $search = $request->input('search', '');
        $perPage = min($request->input('per_page', 10), 50);

        $ledgers = $this->ledgerService->lookupCustomers($search, $perPage);

        // Format for Select2 with extra CRM data
        $results = $ledgers->map(function ($ledger) {
            return [
                'id' => $ledger->id,
                'text' => $ledger->name,
                'mobile' => $ledger->mobile,
                'crm' => [
                    'first_name' => $ledger->first_name,
                    'last_name' => $ledger->last_name,
                    'mobile' => $ledger->mobile,
                    'CL_Number' => $ledger->CL_Number,
                ],
            ];
        });

        return response()->json([
            'results' => $results,
            'pagination' => [
                'more' => $ledgers->hasMorePages(),
                'current_page' => $ledgers->currentPage(),
                'total' => $ledgers->total(),
            ]
        ]);
    }

    /**
     * Export all ledger accounts to Excel
     *
     * Download all ledger accounts as an Excel (.xlsx) file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportExcel()
    {
        return Excel::download(new LedgerOfAccountExport(), 'ledger_of_accounts.xlsx');
    }

}
