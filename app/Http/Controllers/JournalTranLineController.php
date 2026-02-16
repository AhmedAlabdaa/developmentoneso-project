<?php

namespace App\Http\Controllers;

use App\Http\Resources\JournalTranLineResource;
use App\Queries\JournalTranLineQuery;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @group Journal Transaction Lines
 *
 * APIs for querying journal transaction lines from posted journal vouchers.
 */
class JournalTranLineController extends Controller
{
    /**
     * List journal transaction lines
     *
     * Get a paginated list of journal transaction lines with optional filtering.
     * By default, returns lines from posted journal vouchers.
     *
     * @queryParam per_page integer Number of items per page. Example: 20
     * @queryParam sort_by string Field to sort by (id, journal_header_id, ledger_id, debit, credit, created_at, updated_at). Example: created_at
     * @queryParam sort_direction string Sort direction (asc or desc). Example: desc
     * @queryParam journal_header_id integer Filter by journal header ID. Example: 1
     * @queryParam ledger_id integer Filter by ledger account ID. Example: 5
     * @queryParam candidate_id integer Filter by candidate/employee ID. Example: 10
     * @queryParam status integer Filter by journal header status (0=Draft, 1=Posted, 2=Void). Example: 1
     * @queryParam only_posted boolean Filter to only include posted journal entries. Example: true
     * @queryParam posting_date_from date Filter from posting date (Y-m-d). Example: 2026-01-01
     * @queryParam posting_date_to date Filter to posting date (Y-m-d). Example: 2026-01-31
     * @queryParam type string Filter by transaction type (debit or credit). Example: debit
     * @queryParam search string Search across notes and ledger names. Example: payment
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        // Extract query parameters
        $filters = $request->only([
            'journal_header_id', 'ledger_id', 'candidate_id',
            'status', 'only_posted', 'posting_date_from', 'posting_date_to',
            'type', 'search'
        ]);

        $perPage = $request->input('per_page', 15);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');

        $query = new JournalTranLineQuery();
        
        $lines = $query
            ->withRelations()
            ->applyFilters($filters)
            ->sortBy($sortBy, $sortDirection)
            ->paginate((int) $perPage);


        return JournalTranLineResource::collection($lines);
    }

    /**
     * Bulk update journal status
     *
     * Update the status of multiple journal headers by their IDs.
     *
     * @param Request $request
     * @param \App\Services\JournalHeaderService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkUpdateStatus(Request $request, \App\Services\JournalHeaderService $service): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:journal_headers,id'],
            'status' => ['required', 'integer', 'in:0,1,2'],
        ]);

        $status = \App\Enum\JournalStatus::from($validated['status']);
        
        $count = $service->bulkUpdateStatus($validated['ids'], $status);

        return response()->json([
            'message' => 'Journals updated successfully',
            'updated_count' => $count,
        ]);
    }
}
