<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTypingTranGovInvRequest;
use App\Http\Requests\UpdateTypingTranGovInvRequest;
use App\Http\Resources\TypingTranGovInvResource;
use App\Services\TypingTranGovInvService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Typing Transaction Government Invoices
 *
 * APIs for managing Typing Transaction Government Invoices.
 */
class TypingTranGovInvController extends Controller
{
    protected TypingTranGovInvService $service;

    public function __construct(TypingTranGovInvService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the typing transaction government invoices page
     */
    public function viewIndex()
    {
        $now = \Carbon\Carbon::now('Asia/Dubai')->format('l, F d, Y h:i A');
        $items = \App\Models\TypingTranGovInv::with(['ledger', 'journal.lines.ledger', 'journal.preSrc'])
            ->orderByDesc('id')
            ->paginate(10);
            
        return view('typing_tran_gov_inv.index', compact('items', 'now'));
    }

    /**
     * List all items
     *
     * Get a paginated list of items with optional filtering and sorting.
     *
     * @queryParam per_page integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by (id, serial_no, gov_dw_no, created_at, updated_at). Example: created_at
     * @queryParam sort_direction string Sort direction (asc or desc). Example: desc
     * @queryParam search string Search across serial_no and gov_dw_no. Example: GOV-INV
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['search']);

        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $items = $this->service->getPaginated(
            $filters,
            (int) $perPage,
            $sortBy,
            $sortDirection
        );

        return TypingTranGovInvResource::collection($items);
    }

    /**
     * Create a new item
     *
     * Store a newly created item.
     *
     * @bodyParam gov_dw_no string optional Government D/W Number (deprecated, use services.*.dw instead). Example: DW-12345
     * @bodyParam gov_inv_attachments array optional Array of attachment paths or objects.
     * @bodyParam maid_id integer optional Maid ID. Example: 10
     * @bodyParam ledger_of_account_id integer required Ledger/Customer ID. Example: 1
     * @bodyParam services array required Array of services to include in the invoice.
     * @bodyParam services[].invoice_service_id integer required Invoice Service ID. Example: 1
     * @bodyParam services[].quantity number required Quantity for this service. Example: 2
     * @bodyParam services[].dw string optional D/W number for this service line. Example: DW-001
     *
     * @param StoreTypingTranGovInvRequest $request
     * @return JsonResponse
     */
    public function store(StoreTypingTranGovInvRequest $request): JsonResponse
    {
        $item = $this->service->create($request->validated());

        return (new TypingTranGovInvResource($item))
            ->additional([
                'success' => true,
                'message' => 'Typing Transaction Government Invoice created successfully',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a specific item
     *
     * Display the details of a specific item.
     *
     * @urlParam id integer required The ID of the item. Example: 1
     *
     * @param int $id
     * @return JsonResponse|TypingTranGovInvResource
     */
    public function show(int $id)
    {
        $item = $this->service->getById($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }

        return new TypingTranGovInvResource($item);
    }

    /**
     * Update an item
     *
     * Update the details of a specific item.
     *
     * @urlParam id integer required The ID of the item. Example: 1
     * @bodyParam gov_dw_no string optional Government D/W Number (deprecated, use services.*.dw instead). Example: DW-12345
     * @bodyParam gov_inv_attachments array optional Array of attachment paths or objects.
     * @bodyParam maid_id integer optional Maid ID. Example: 10
     * @bodyParam ledger_of_account_id integer optional Ledger/Customer ID. Example: 1
     * @bodyParam services array optional Array of services to include in the invoice.
     * @bodyParam services[].invoice_service_id integer required Invoice Service ID. Example: 1
     * @bodyParam services[].quantity number required Quantity for this service. Example: 2
     * @bodyParam services[].dw string optional D/W number for this service line. Example: DW-001
     *
     * @param UpdateTypingTranGovInvRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateTypingTranGovInvRequest $request, int $id): JsonResponse
    {
        $item = $this->service->update($id, $request->validated());

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }

        return (new TypingTranGovInvResource($item))
            ->additional([
                'success' => true,
                'message' => 'Typing Transaction Government Invoice updated successfully',
            ])
            ->response();
    }

    /**
     * Delete an item
     *
     * Remove a specific item from the database.
     *
     * @urlParam id integer required The ID of the item to delete. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Typing Transaction Government Invoice deleted successfully',
        ], 200);
    }

    /**
     * Receive payment for a typing invoice
     *
     * Create a receipt voucher for a specific typing invoice and record the payment
     * with proper journal entries. This endpoint creates a ReceiptVoucher linked to 
     * the typing invoice via polymorphic relationship and updates the amount_received.
     *
     * @urlParam id integer required The ID of the typing invoice. Example: 1
     * @bodyParam credit_ledger_id integer required Ledger account to credit (usually the customer account). Example: 10
     * @bodyParam debit_ledger_id integer required Ledger account to debit (usually cash/bank account). Example: 20
     * @bodyParam amount number required Payment amount received. Example: 500.00
     * @bodyParam attachments array optional Array of attachment URLs. Example: ["url1", "url2"]
     * @bodyParam status string optional Voucher status (draft, posted, void). Defaults to posted. Example: posted
     * @bodyParam payment_mode integer optional Payment mode code. Example: 1
     *
     * @param \App\Http\Requests\ReceiveTypingInvoicePaymentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function receivePayment(\App\Http\Requests\ReceiveTypingInvoicePaymentRequest $request, int $id): JsonResponse
    {
        $receiptVoucher = $this->service->receivePayment($id, $request->validated());

        if (!$receiptVoucher) {
            return response()->json([
                'success' => false,
                'message' => 'Typing invoice not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment received successfully',
            'data' => new \App\Http\Resources\ReceiptVoucherResource($receiptVoucher),
        ], 201);
    }
}
