<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeductionPayrollRequest;
use App\Http\Requests\UpdateDeductionPayrollRequest;
use App\Http\Resources\DeductionPayrollResource;
use App\Queries\DeductionPayrollQuery;
use App\Services\DeductionPayrollService;
use Exception;
use Illuminate\Http\Request;

/**
 * @group Package 3 Modular
 * @subgroup Deduction Payroll
 *
 * APIs for managing employee payroll deductions and allowances.
 */
class DeductionPayrollController extends Controller
{
    protected DeductionPayrollService $service;
    protected DeductionPayrollQuery $query;

    public function __construct(DeductionPayrollService $service, DeductionPayrollQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List deduction payroll records.
     *
     * Returns paginated deduction payroll records with optional filters.
     *
     * @queryParam per_page integer Number of items per page. Example: 15
     * @queryParam employee_id integer Filter by employee ID. Example: 10
     * @queryParam payroll_year integer Filter by payroll year. Example: 2026
     * @queryParam payroll_month integer Filter by payroll month. Example: 2
     * @queryParam deduction_date_from date Filter from deduction date. Example: 2026-02-01
     * @queryParam deduction_date_to date Filter to deduction date. Example: 2026-02-29
     * @queryParam search string Search in note field. Example: penalty
     * @queryParam sort_by string Sort field. Example: created_at
     * @queryParam sort_direction string Sort direction (`asc` or `desc`). Example: desc
     */
    public function index(Request $request)
    {
        $records = $this->query->getDeductionPayrolls(
            $request->only([
                'employee_id',
                'payroll_year',
                'payroll_month',
                'deduction_date_from',
                'deduction_date_to',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            (int) $request->input('per_page', 15)
        );

        return DeductionPayrollResource::collection($records);
    }

    /**
     * Store deduction payroll record(s).
     *
     * Supports single-row create and bulk create in one endpoint.
     *
     * Single row payload fields:
     * @bodyParam employee_id integer required Employee ID. Example: 10
     * @bodyParam payroll_year integer required Payroll year. Example: 2026
     * @bodyParam payroll_month integer required Payroll month (1-12). Example: 2
     * @bodyParam deduction_date date Optional deduction date. Example: 2026-02-22
     * @bodyParam amount_deduction number Optional deduction amount. Example: 150
     * @bodyParam amount_allowance number Optional allowance amount. Example: 50
     * @bodyParam note string Optional note. Example: Late penalty
     *
     * Bulk payload fields:
     * @bodyParam rows array Optional array for bulk create.
     * @bodyParam rows[].employee_id integer required_with:rows Employee ID. Example: 10
     * @bodyParam rows[].payroll_year integer required_with:rows Payroll year. Example: 2026
     * @bodyParam rows[].payroll_month integer required_with:rows Payroll month (1-12). Example: 2
     * @bodyParam rows[].deduction_date date Optional deduction date. Example: 2026-02-22
     * @bodyParam rows[].amount_deduction number Optional deduction amount. Example: 150
     * @bodyParam rows[].amount_allowance number Optional allowance amount. Example: 50
     * @bodyParam rows[].note string Optional note. Example: Bonus adjustment
     */
    public function store(StoreDeductionPayrollRequest $request)
    {
        try {
            $validated = $request->validated();

            if (!empty($validated['rows']) && is_array($validated['rows'])) {
                $records = $this->service->createMany($validated['rows']);

                return response()->json([
                    'message' => 'Deduction payroll rows created successfully',
                    'data' => DeductionPayrollResource::collection($records),
                ], 201);
            }

            $record = $this->service->create($validated);

            return response()->json([
                'message' => 'Deduction payroll created successfully',
                'data' => new DeductionPayrollResource($record),
            ], 201);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'deduction_unique_row') ? 422 : 500;

            return response()->json([
                'message' => $status === 422 ? 'Duplicate payroll period for this employee' : 'Failed to create deduction payroll',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Show deduction payroll record.
     *
     * @urlParam id integer required Deduction payroll ID. Example: 1
     */
    public function show(int $id)
    {
        try {
            return new DeductionPayrollResource($this->query->getById($id));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Deduction payroll not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update deduction payroll record.
     *
     * @urlParam id integer required Deduction payroll ID. Example: 1
     * @bodyParam employee_id integer Employee ID. Example: 10
     * @bodyParam payroll_year integer Payroll year. Example: 2026
     * @bodyParam payroll_month integer Payroll month (1-12). Example: 2
     * @bodyParam deduction_date date Deduction date. Example: 2026-02-22
     * @bodyParam amount_deduction number Deduction amount. Example: 150
     * @bodyParam amount_allowance number Allowance amount. Example: 50
     * @bodyParam note string Optional note. Example: Updated note
     */
    public function update(UpdateDeductionPayrollRequest $request, int $id)
    {
        try {
            $record = $this->query->getById($id);
            $updated = $this->service->update($record, $request->validated());

            return response()->json([
                'message' => 'Deduction payroll updated successfully',
                'data' => new DeductionPayrollResource($updated),
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : (str_contains($e->getMessage(), 'deduction_unique_row') ? 422 : 500);

            return response()->json([
                'message' => $status === 404 ? 'Deduction payroll not found' : ($status === 422 ? 'Duplicate payroll period for this employee' : 'Failed to update deduction payroll'),
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete deduction payroll record.
     *
     * @urlParam id integer required Deduction payroll ID. Example: 1
     */
    public function destroy(int $id)
    {
        try {
            $record = $this->query->getById($id);
            $this->service->delete($record);

            return response()->json([
                'message' => 'Deduction payroll deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Deduction payroll not found' : 'Failed to delete deduction payroll',
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
