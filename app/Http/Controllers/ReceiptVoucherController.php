<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReceiptVoucherRequest;
use App\Http\Requests\UpdateReceiptVoucherRequest;
use App\Http\Resources\ReceiptVoucherResource;
use App\Services\ReceiptVoucherService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Receipt Vouchers
 *
 * APIs for managing receipt vouchers with automatic journal entry creation.
 */
class ReceiptVoucherController extends Controller
{
    public function __construct(protected ReceiptVoucherService $service)
    {
    }

    /**
     * List all receipt vouchers
     *
     * Get a paginated list of receipt vouchers with optional filtering and sorting.
     *
     * @queryParam limit integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by (id, serial_number, status, payment_mode, created_at, updated_at). Example: created_at
     * @queryParam sort_desc string Sort in descending order (true or false). Example: true
     * @queryParam search string Search by serial number. Example: RV-000001
     * @queryParam status string Filter by status (draft, posted, void). Example: posted
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['search', 'status']);
        $perPage = $request->get('limit', 15);
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_desc') === 'true' ? 'desc' : 'asc';

        $items = $this->service->getPaginated($filters, $perPage, $sortBy, $sortDirection);

        return ReceiptVoucherResource::collection($items);
    }

    /**
     * Get a specific receipt voucher
     *
     * Display the details of a specific receipt voucher with its source and journal entry.
     *
     * @urlParam id integer required The ID of the receipt voucher. Example: 1
     *
     * @param int $id
     * @return JsonResponse|ReceiptVoucherResource
     */
    public function show($id)
    {
        $item = $this->service->getById($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt voucher not found'
            ], 404);
        }

        return new ReceiptVoucherResource($item);
    }

    /**
     * Create a new receipt voucher
     *
     * Store a newly created receipt voucher with automatic journal entry creation.
     * The journal entry will be created with a debit to the specified debit_ledger_id 
     * and a credit to the credit_ledger_id for the specified amount.
     *
     * @bodyParam candidate_id integer optional Link to a candidate. Example: 5
     * @bodyParam credit_ledger_id integer required Ledger account to credit. Example: 10
     * @bodyParam debit_ledger_id integer required Ledger account to debit. Example: 20
     * @bodyParam amount number required Receipt amount. Example: 1500.00
     * @bodyParam attachments array optional Array of attachment URLs. Example: ["url1", "url2"]
     * @bodyParam status string optional Voucher status (draft, posted, void). Defaults to draft. Example: posted
     * @bodyParam payment_mode integer optional Payment mode code. Example: 1
     *
     * @param StoreReceiptVoucherRequest $request
     * @return JsonResponse
     */
    public function store(StoreReceiptVoucherRequest $request): JsonResponse
    {
        $item = $this->service->create($request->validated());

        return (new ReceiptVoucherResource($item))
            ->additional([
                'success' => true,
                'message' => 'Receipt voucher created successfully',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update a receipt voucher
     *
     * Update the details of a specific receipt voucher and its associated journal entry.
     *
     * @urlParam id integer required The ID of the receipt voucher. Example: 1
     * @bodyParam candidate_id integer optional Link to a candidate. Example: 5
     * @bodyParam credit_ledger_id integer optional Ledger account to credit. Example: 10
     * @bodyParam debit_ledger_id integer optional Ledger account to debit. Example: 20
     * @bodyParam amount number optional Receipt amount. Example: 2000.00
     * @bodyParam status string optional Voucher status (draft, posted, void). Example: posted
     * @bodyParam payment_mode integer optional Payment mode code. Example: 2
     *
     * @param UpdateReceiptVoucherRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateReceiptVoucherRequest $request, $id): JsonResponse
    {
        $item = $this->service->update($id, $request->validated());

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt voucher not found'
            ], 404);
        }

        return (new ReceiptVoucherResource($item))
            ->additional([
                'success' => true,
                'message' => 'Receipt voucher updated successfully',
            ])
            ->response();
    }

    /**
     * Delete a receipt voucher
     *
     * Remove a specific receipt voucher and its associated journal entry from the database.
     *
     * @urlParam id integer required The ID of the receipt voucher to delete. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt voucher not found or could not be deleted'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Receipt voucher deleted successfully'
        ], 200);
    }
}
