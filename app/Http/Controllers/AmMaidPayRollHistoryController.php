<?php

namespace App\Http\Controllers;

use App\Exports\AmMaidPayrollHistoryExport;
use App\Http\Requests\StoreAmMaidPayRollRequest;
use App\Http\Requests\UpdateAmMaidPayRollRequest;
use App\Http\Resources\AmMaidPayRollResource;
use App\Queries\AmMaidPayRollHistoryQuery;
use App\Services\AmMaidPayRollHistoryService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

/**
 * @group Package 3 Modular
 * @subgroup Maid Payroll History
 *
 * APIs for managing maid payroll history records.
 */
class AmMaidPayRollHistoryController extends Controller
{
    protected AmMaidPayRollHistoryService $service;
    protected AmMaidPayRollHistoryQuery $query;

    public function __construct(AmMaidPayRollHistoryService $service, AmMaidPayRollHistoryQuery $query)
    {
        $this->service = $service;
        $this->query = $query;
    }

    /**
     * List payroll histories.
     *
     * @queryParam per_page integer Number of items per page. Example: 15
     * @queryParam employee_id integer Filter by employee ID. Example: 10
     * @queryParam year integer Filter by payroll year. Example: 2026
     * @queryParam month integer Filter by payroll month (1-12). Example: 2
     * @queryParam status string Filter by status. Example: paid
     * @queryParam payment_method string Filter by payment method. Example: cash
     * @queryParam search string Search in note field. Example: bonus
     * @queryParam sort_by string Sort field. Example: created_at
     * @queryParam sort_direction string Sort direction (`asc` or `desc`). Example: desc
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 1,
     *       "employee_id": 10,
     *       "year": 2026,
     *       "month": 2,
     *       "payment_method": "bank",
     *       "basic_salary": "1500.00",
     *       "deduction": "200.00",
     *       "allowance": "100.00",
     *       "net": "1400.00",
     *       "note": "February payroll",
     *       "status": "paid",
     *       "created_at": "2026-02-28T10:00:00.000000Z",
     *       "updated_at": "2026-02-28T10:00:00.000000Z"
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function index(Request $request)
    {
        $records = $this->query->getPayrollHistories(
            $request->only([
                'employee_id',
                'year',
                'month',
                'status',
                'payment_method',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            (int) $request->input('per_page', 15)
        );

        return AmMaidPayRollResource::collection($records);
    }

    /**
     * Export payroll histories to Excel.
     *
     * @queryParam year integer required Payroll year. Example: 2026
     * @queryParam month integer required Payroll month (1-12). Example: 2
     * @response 200 {
     *   "message": "Excel file download started"
     * }
     */
    public function export(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $tempPath = storage_path('framework/cache/laravel-excel');
        if (!is_dir($tempPath)) {
            @mkdir($tempPath, 0777, true);
        }
        @chmod($tempPath, 0777);

        config([
            'excel.temporary_files.local_path' => $tempPath,
            'excel.temporary_files.local_permissions.dir' => 0777,
            'excel.temporary_files.local_permissions.file' => 0666,
        ]);

        $rows = $this->query->getExportRows((int) $validated['year'], (int) $validated['month']);
        $filename = 'payroll_history_' . $validated['year'] . '_' . str_pad((string) $validated['month'], 2, '0', STR_PAD_LEFT) . '_' . Carbon::now()->format('Ymd_His') . '.xlsx';

        return Excel::download(new AmMaidPayrollHistoryExport($rows), $filename);
    }

    /**
     * Store payroll history record(s).
     *
     * Creates payroll history rows in bulk with per-employee values.
     *
     * @bodyParam year integer required Payroll year for all rows. Example: 2026
     * @bodyParam month integer required Payroll month (1-12) for all rows. Example: 2
     * @bodyParam note string Optional note applied to all rows. Example: February payroll
     * @bodyParam rows array required Payroll rows. Example: [{"employee_id":10,"payment_method":"bank","basic_salary":1500,"deduction":200,"allowance":100,"net":1400,"paid_at":"2026-02-28 10:00:00","status":"paid"},{"employee_id":11,"payment_method":"cash","basic_salary":1800,"deduction":50,"allowance":0,"net":1750,"paid_at":"2026-02-28 10:00:00","status":"paid"}]
     * @bodyParam rows.*.employee_id integer required Employee ID. Example: 10
     * @bodyParam rows.*.payment_method string Optional payment method. Example: bank
     * @bodyParam rows.*.basic_salary number Optional basic salary. Example: 1500
     * @bodyParam rows.*.deduction number Optional deduction amount. Example: 200
     * @bodyParam rows.*.allowance number Optional allowance amount. Example: 100
     * @bodyParam rows.*.net number Optional net amount. Example: 1400
     * @bodyParam rows.*.paid_at date Optional paid date/time. Example: 2026-02-28 10:00:00
     * @bodyParam rows.*.status string Optional status. Example: paid
     */
    public function store(StoreAmMaidPayRollRequest $request)
    {
        try {
            $validated = $request->validated();
            $records = $this->service->createManyByRows($validated);

            return response()->json([
                'message' => 'Payroll histories created successfully',
                'data' => AmMaidPayRollResource::collection($records),
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create payroll history',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show payroll history record.
     *
     * @urlParam id integer required Payroll history ID. Example: 1
     * @response 200 {
     *   "id": 1,
     *   "employee_id": 10,
     *   "year": 2026,
     *   "month": 2,
     *   "payment_method": "bank",
     *   "basic_salary": "1500.00",
     *   "deduction": "200.00",
     *   "allowance": "100.00",
     *   "net": "1400.00",
     *   "note": "February payroll",
     *   "status": "paid",
     *   "created_at": "2026-02-28T10:00:00.000000Z",
     *   "updated_at": "2026-02-28T10:00:00.000000Z"
     * }
     * @response 404 {
     *   "message": "Payroll history not found"
     * }
     */
    public function show(int $id)
    {
        try {
            return new AmMaidPayRollResource($this->query->getById($id));
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Payroll history not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update payroll history record.
     *
     * @urlParam id integer required Payroll history ID. Example: 1
     * @bodyParam employee_id integer Employee ID. Example: 10
     * @bodyParam year integer Payroll year. Example: 2026
     * @bodyParam month integer Payroll month (1-12). Example: 2
     * @bodyParam payment_method string Payment method. Example: bank
     * @bodyParam basic_salary number Basic salary. Example: 1500
     * @bodyParam deduction number Deduction amount. Example: 200
     * @bodyParam allowance number Allowance amount. Example: 100
     * @bodyParam net number Net amount. Example: 1400
     * @bodyParam note string Optional note. Example: Updated note
     * @bodyParam paid_at date Optional paid date/time. Example: 2026-02-28 10:00:00
     * @bodyParam status string Status. Example: paid
     */
    public function update(UpdateAmMaidPayRollRequest $request, int $id)
    {
        try {
            $record = $this->query->getById($id);
            $updated = $this->service->update($record, $request->validated());

            return response()->json([
                'message' => 'Payroll history updated successfully',
                'data' => new AmMaidPayRollResource($updated),
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Payroll history not found' : 'Failed to update payroll history',
                'error' => $e->getMessage(),
            ], $status);
        }
    }

    /**
     * Delete payroll history record.
     *
     * @urlParam id integer required Payroll history ID. Example: 1
     */
    public function destroy(int $id)
    {
        try {
            $record = $this->query->getById($id);
            $this->service->delete($record);

            return response()->json([
                'message' => 'Payroll history deleted successfully',
            ]);
        } catch (Exception $e) {
            $status = str_contains($e->getMessage(), 'No query results') ? 404 : 500;

            return response()->json([
                'message' => $status === 404 ? 'Payroll history not found' : 'Failed to delete payroll history',
                'error' => $e->getMessage(),
            ], $status);
        }
    }
}
