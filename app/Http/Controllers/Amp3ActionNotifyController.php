<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmp3ActionNotifyRequest;
use App\Http\Requests\UpdateAmp3ActionNotifyRequest;
use App\Http\Resources\Amp3ActionNotifyResource;
use App\Queries\Amp3ActionNotifyQuery;
use App\Services\ReturnMaid\AmReturnMaidService;
use Exception;
use Illuminate\Http\Request;

/**
 * @group Package 3 Modular
 * @subgroup Refund Action Notify
 *
 * APIs for managing refund action notify records.
 */
class Amp3ActionNotifyController extends Controller
{
    protected AmReturnMaidService $service;
    protected Amp3ActionNotifyQuery $query;

    public function __construct(AmReturnMaidService $service, Amp3ActionNotifyQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List action notify records.
     *
     * Returns paginated refund action notifications.
     *
     * @queryParam per_page integer Number of items per page. Example: 15
     * @queryParam am_contract_movement_id integer Filter by contract movement ID. Example: 4
     * @queryParam status integer Filter by status (0 = pending, 1 = approved, 2 = rejected). Example: 0
     */
    public function index(Request $request)
    {
        $records = $this->query->getActionNotifies(
            $request->only([
                'am_contract_movement_id',
                'status',
                'refund_date_from',
                'refund_date_to',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            $request->input('per_page', 15)
        );

        return Amp3ActionNotifyResource::collection($records);
    }

    /**
     * Raise a refund action notify.
     *
     * @bodyParam am_contract_movement_id integer required Contract movement ID. Example: 4
     * @bodyParam amount number required Refund amount. Example: 1200
     * @bodyParam note string Refund note. Example: Customer requested refund
     * @bodyParam refund_date date required Refund date. Example: 2026-02-21
     */
    public function store(StoreAmp3ActionNotifyRequest $request)
    {
        try {
            $record = $this->service->raiseRefund($request->validated());

            return response()->json([
                'message' => 'Refund raised successfully',
                'data' => new Amp3ActionNotifyResource($record),
            ], 201);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') || str_contains($e->getMessage(), 'not found') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Return maid record not found for this movement' : 'Failed to raise refund',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Show a single action notify.
     *
     * @urlParam id integer required Action notify ID. Example: 1
     */
    public function show(int $id)
    {
        try {
            $record = $this->query->getById($id);

            return new Amp3ActionNotifyResource($record);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Action notify not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update an action notify.
     *
     * @urlParam id integer required Action notify ID. Example: 1
     * @bodyParam am_contract_movement_id integer Contract movement ID. Example: 4
     * @bodyParam amount number Refund amount. Example: 1200
     * @bodyParam note string Refund note. Example: Updated refund note
     * @bodyParam refund_date date Refund date. Example: 2026-02-22
     * @bodyParam status integer Status (0 = pending, 1 = approved, 2 = rejected). Example: 1
     */
    public function update(UpdateAmp3ActionNotifyRequest $request, int $id)
    {
        try {
            $record = $this->query->getById($id);
            $updated = $this->service->updateActionNotify($record, $request->validated());

            return response()->json([
                'message' => 'Action notify updated successfully',
                'data' => new Amp3ActionNotifyResource($updated),
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Action notify not found' : 'Failed to update action notify',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete an action notify.
     *
     * @urlParam id integer required Action notify ID. Example: 1
     */
    public function destroy(int $id)
    {
        try {
            $record = $this->query->getById($id);
            $this->service->deleteActionNotify($record);

            return response()->json([
                'message' => 'Action notify deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Action notify not found' : 'Failed to delete action notify',
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
