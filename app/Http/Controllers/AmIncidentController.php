<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmIncidentRequest;
use App\Http\Requests\UpdateAmIncidentRequest;
use App\Http\Resources\AmIncidentResource;
use App\Queries\AmIncidentQuery;
use App\Services\AmIncidentService;
use Illuminate\Http\Request;
use Exception;

/**
 * @group Package 3 Modular
 * @subgroup Incidents
 *
 * APIs for managing incidents (Ran Away, Cancelled, Hold) related to monthly contracts.
 * These records share the am_return_maids table.
 */
class AmIncidentController extends Controller
{
    protected $service;
    protected $query;

    public function __construct(AmIncidentService $service, AmIncidentQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List incidents.
     *
     * Returns a paginated list of incidents (RanAway, Cancelled, Hold).
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam status integer Filter by status (2 = Ran Away, 3 = Cancelled, 4 = Hold). Example: 2
     * @queryParam employee_id integer Filter by employee ID. Example: 5
     * @queryParam crm_id integer Filter by customer ID. Example: 1
     *
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "date": "2026-02-20",
     *       "status": 2,
     *       "status_label": "Ran Away",
     *       "note": "Incident note"
     *     }
     *   ]
     * }
     */
    public function index(Request $request)
    {
        $incidents = $this->query->getIncidents($request->all(), $request->input('per_page', 15));
        return AmIncidentResource::collection($incidents);
    }

    /**
     * Store a new incident.
     *
     * @response 201 {
     *   "message": "Incident created successfully",
     *   "data": {}
     * }
     */
    public function store(StoreAmIncidentRequest $request)
    {
        try {
            $incident = $this->service->createIncident($request->validated());
            return response()->json([
                'message' => 'Incident created successfully',
                'data'    => new AmIncidentResource($incident),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create incident',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display a specific incident.
     */
    public function show($id)
    {
        try {
            $incident = $this->query->getById($id);
            return new AmIncidentResource($incident);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Incident not found',
                'error'   => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update an incident.
     */
    public function update(UpdateAmIncidentRequest $request, $id)
    {
        try {
            $incident = $this->query->getById($id);
            $updatedIncident = $this->service->updateIncident($incident, $request->validated());
            return response()->json([
                'message' => 'Incident updated successfully',
                'data'    => new AmIncidentResource($updatedIncident),
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Incident not found' : 'Failed to update incident',
                'error'   => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete an incident.
     */
    public function destroy($id)
    {
        try {
            $incident = $this->query->getById($id);
            $this->service->deleteIncident($incident);
            return response()->json([
                'message' => 'Incident deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;
            return response()->json([
                'message' => $status === 404 ? 'Incident not found' : 'Failed to delete incident',
                'error'   => $e->getMessage(),
            ], $status);
        }
    }
}
