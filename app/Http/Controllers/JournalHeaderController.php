<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJournalHeaderRequest;
use App\Http\Requests\UpdateJournalHeaderRequest;
use App\Http\Resources\JournalHeaderResource;
use App\Services\JournalHeaderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Journal Entries
 *
 * APIs for managing journal entries (headers) with nested transaction lines.
 */
class JournalHeaderController extends Controller
{
    protected JournalHeaderService $journalService;

    public function __construct(JournalHeaderService $journalService)
    {
        $this->journalService = $journalService;
    }

    /**
     * List all journal entries
     *
     * Get a paginated list of journal entries with optional filtering and sorting.
     *
     * @queryParam per_page integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by (id, posting_date, status, total_debit, total_credit, created_at, updated_at, posted_at). Example: posting_date
     * @queryParam sort_direction string Sort direction (asc or desc). Example: desc
     * @queryParam status string Filter by status. Example: DRAFT
     * @queryParam posting_date_from date Filter from posting date (Y-m-d). Example: 2026-01-01
     * @queryParam posting_date_to date Filter to posting date (Y-m-d). Example: 2026-01-31
     * @queryParam source_type string Filter by source type. Example: App\Models\Invoice
     * @queryParam source_id integer Filter by source ID. Example: 123
     * @queryParam created_by integer Filter by creator user ID. Example: 1
     * @queryParam posted_by integer Filter by poster user ID. Example: 1
     * @queryParam created_from date Filter from created date (Y-m-d). Example: 2026-01-01
     * @queryParam created_to date Filter to created date (Y-m-d). Example: 2026-01-31
     * @queryParam search string Search across notes. Example: payment
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // Extract query parameters
        $filters = $request->only([
            'status', 'posting_date_from', 'posting_date_to',
            'source_type', 'source_id', 'created_by', 'posted_by',
            'created_from', 'created_to', 'search'
        ]);

        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $journals = $this->journalService->getPaginatedJournals(
            $filters,
            (int) $perPage,
            $sortBy,
            $sortDirection
        );

        return JournalHeaderResource::collection($journals);
    }

    /**
     * Create a new journal entry
     *
     * Store a newly created journal entry with nested transaction lines.
     *
     * @bodyParam posting_date date required The posting date. Example: 2026-01-07
     * @bodyParam status integer required The status: 0=Draft, 1=Posted, 2=Void. Example: 0
     * @bodyParam source_type string optional Source model type. Example: App\Models\Invoice
     * @bodyParam source_id integer optional Source model ID. Example: 123
     * @bodyParam pre_src_type string optional Previous source type. Example: App\Models\Order
     * @bodyParam pre_src_id integer optional Previous source ID. Example: 456
     * @bodyParam note string optional Journal notes. Example: Monthly payment entry
     * @bodyParam meta_json object optional Additional metadata. Example: {"reference": "PAY-001"}
     * @bodyParam lines array required Array of transaction lines (minimum 2). Total debits must equal total credits.
     * @bodyParam lines[].ledger_id integer required Ledger account ID. Example: 1
     * @bodyParam lines[].candidate_id integer optional Employee ID. Example: 5
     * @bodyParam lines[].debit number required Debit amount (use 0 if credit entry). Example: 1000.00
     * @bodyParam lines[].credit number required Credit amount (use 0 if debit entry). Example: 0.00
     * @bodyParam lines[].note string optional Line note. Example: Payment received
     *
     * @param StoreJournalHeaderRequest $request
     * @return JsonResponse
     */
    public function store(StoreJournalHeaderRequest $request): JsonResponse
    {
        $journal = $this->journalService->createJournal($request->validated());

        return (new JournalHeaderResource($journal))
            ->additional([
                'success' => true,
                'message' => 'Journal entry created successfully',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Get a specific journal entry
     *
     * Display the details of a specific journal entry with nested lines.
     *
     * @urlParam id integer required The ID of the journal entry. Example: 1
     *
     * @param int $id
     * @return JsonResponse|JournalHeaderResource
     */
    public function show(int $id)
    {
        $journal = $this->journalService->getJournalById($id);

        if (!$journal) {
            return response()->json([
                'success' => false,
                'message' => 'Journal entry not found',
            ], 404);
        }

        return new JournalHeaderResource($journal);
    }

    /**
     * Update a journal entry
     *
     * Update the details of a specific journal entry and its nested lines.
     *
     * @urlParam id integer required The ID of the journal entry. Example: 1
     * @bodyParam posting_date date optional The posting date. Example: 2026-01-08
     * @bodyParam status integer optional The status: 0=Draft, 1=Posted, 2=Void. Example: 1
     * @bodyParam note string optional Journal notes. Example: Updated entry
     * @bodyParam lines array optional Array of transaction lines. Include 'id' to update existing lines, omit to create new ones.
     *
     * @param UpdateJournalHeaderRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateJournalHeaderRequest $request, int $id): JsonResponse
    {
        $journal = $this->journalService->updateJournal($id, $request->validated());

        if (!$journal) {
            return response()->json([
                'success' => false,
                'message' => 'Journal entry not found',
            ], 404);
        }

        return (new JournalHeaderResource($journal))
            ->additional([
                'success' => true,
                'message' => 'Journal entry updated successfully',
            ])
            ->response();
    }

    /**
     * Delete a journal entry
     *
     * Remove a specific journal entry and its transaction lines from the database.
     *
     * @urlParam id integer required The ID of the journal entry to delete. Example: 1
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->journalService->deleteJournal($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Journal entry not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Journal entry deleted successfully',
        ], 200);
    }
}
