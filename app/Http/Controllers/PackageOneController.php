<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageOneRequest;
use App\Http\Requests\ReceivedVoucherPackageOneRequest;
use App\Http\Requests\CreditNotePackageOneRequest;
use App\Http\Requests\ChargingPackageOneRequest;
use App\Http\Resources\JournalHeaderResource;
use App\Http\Resources\ReceiptVoucherResource;
use App\Services\PackageOneService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Package One
 *
 * APIs for creating Package One journal entries (financial impact only).
 * Invoices are created separately via InvoiceController.
 */
class PackageOneController extends Controller
{
    protected PackageOneService $service;

    public function __construct(PackageOneService $service)
    {
        $this->service = $service;
    }

    /**
     * List Package One Journal Entries
     *
     * Get a paginated list of Package One journal entries.
     *
     * @queryParam per_page integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by. Example: id
     * @queryParam sort_direction string Sort direction (asc or desc). Example: desc
     * @queryParam cn_number string Filter by CN Number. Example: CN-2026
     * @queryParam search string Search in note or CN_Number. Example: PKG
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['cn_number', 'search']);
        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'desc');

        $result = $this->service->getPaginated($filters, $perPage, $sortBy, $sortDirection);

        return JournalHeaderResource::collection($result);
    }

    /**
     * Create Package One Journal Entry
     *
     * Create journal entries for Package One (financial impact only).
     * The cn_number will be stored in all journal transaction lines.
     * Invoice creation is handled separately via InvoiceController.
     *
     * @return JsonResponse
     */
    public function store(StorePackageOneRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $journal = $this->service->create($data);

            return response()->json([
                'message' => 'Package One journal entry created successfully',
                'data' => new JournalHeaderResource($journal->load(['lines.ledger', 'preSrc'])),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create Package One journal entry',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get Package One Journal Entry
     *
     * Display a specific Package One journal entry.
     *
     * @urlParam id integer required The journal ID. Example: 1
     *
     * @param int $id
     * @return JsonResponse|JournalHeaderResource
     */
    public function show(int $id)
    {
        $journal = $this->service->getById($id);

        if (!$journal) {
            return response()->json(['message' => 'Journal entry not found'], 404);
        }

        return new JournalHeaderResource($journal);
    }

    /**
     * Delete Package One Journal Entry
     *
     * Delete a Package One journal entry and its lines.
     *
     * @urlParam id integer required The journal ID. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->service->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Journal entry not found'], 404);
        }

        return response()->json(['message' => 'Package One journal entry deleted successfully']);
    }

    /**
     * Create Received Voucher for Package One
     *
     * Create a receipt voucher for Package One, linked to an Invoice as source.
     * The customer's ledger account is used as the credit side, and the provided
     * debit_ledger_id is used as the debit side (e.g., Cash/Bank).
     *
     * @return JsonResponse
     */
    public function receivedVoucher(ReceivedVoucherPackageOneRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $receiptVoucher = $this->service->receivedVoucher($data);

            return response()->json([
                'message' => 'Receipt voucher created successfully',
                'data' => new ReceiptVoucherResource($receiptVoucher),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create receipt voucher',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Create Credit Note for Package One
     *
     * Create a credit note that reverses the original journal entries for an invoice.
     * The original debit becomes credit and vice versa. The invoice will be marked as refunded.
     *
     * @return JsonResponse
     */
    public function creditNote(CreditNotePackageOneRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $journal = $this->service->creditNote($data);

            return response()->json([
                'message' => 'Credit note created successfully',
                'data' => new JournalHeaderResource($journal->load(['lines.ledger', 'source'])),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create credit note',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Create Charging Entry for Package One
     *
     * Create a charging journal entry with custom lines (ledger_id with debit/credit amounts).
     * The invoice is referenced as the source.
     *
     * @return JsonResponse
     */
    public function charging(ChargingPackageOneRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $journal = $this->service->charging($data);

            return response()->json([
                'message' => 'Charging entry created successfully',
                'data' => new JournalHeaderResource($journal->load(['lines.ledger', 'source'])),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create charging entry',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}

