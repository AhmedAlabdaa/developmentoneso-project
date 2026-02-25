<?php

namespace App\Http\Controllers;

use App\Queries\AmMaidPayRollQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @group Package 3 Modular
 * @subgroup Maid Payroll
 *
 * APIs for maid payroll salary calculations.
 */
class AmMaidPayRollController extends Controller
{
    protected AmMaidPayRollQuery $query;

    public function __construct(AmMaidPayRollQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Salary calculation.
     *
     * Returns a paginated list of maids with their working days, salary,
     * last contract, and last customer for the given year and month.
     *
     * Working days are calculated from contract movement (hire) dates and
     * return dates, clamped to the selected month boundaries.
     *
     * @queryParam year integer required The year. Example: 2026
     * @queryParam month integer required The month (1-12). Example: 2
     * @queryParam per_page integer Items per page. Default: 50. Example: 25
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "employee_id": 5,
     *       "maid_name": "Maria Santos",
     *       "maid_salary": "1500.00",
     *       "last_contract_id": 12,
     *       "last_customer_name": "John Doe",
     *       "working_days": 28
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 50,
     *   "total": 1
     * }
     * @response 422 {
     *   "message": "Validation failed",
     *   "errors": {}
     * }
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year'  => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $this->query->getSalaryCalculation(
            (int) $request->year,
            (int) $request->month,
            (int) $request->input('per_page', 50)
        );

        return response()->json($data);
    }

    /**
     * Employee breakdown.
     *
     * Returns detailed contract movement records for a single employee
     * during the given year and month, including contract info, customer,
     * return date, and working days per movement.
     *
     * @urlParam employee_id integer required The employee ID. Example: 5
     * @queryParam year integer required The year. Example: 2026
     * @queryParam month integer required The month (1-12). Example: 2
     *
     * @response 200 {
     *   "employee": {
     *     "id": 5,
     *     "name": "Maria Santos",
     *     "salary": "1500.00",
     *     "nationality": "Philippines",
     *     "reference_no": "EMP-0005"
     *   },
     *   "year": 2026,
     *   "month": 2,
     *   "month_start": "2026-02-01",
     *   "month_end": "2026-02-28",
     *   "movements": [
     *     {
     *       "movement_id": 10,
     *       "movement_date": "2026-01-15",
     *       "movement_note": "Assigned",
     *       "movement_status": 1,
     *       "contract_id": 12,
     *       "contract_ref": "p4_00012",
     *       "customer_name": "John Doe",
     *       "customer_cl": "CL-00001",
     *       "return_id": null,
     *       "return_date": null,
     *       "return_note": null,
     *       "working_days": 28
     *     }
     *   ],
     *   "total_working_days": 28
     * }
     * @response 404 {
     *   "message": "Employee not found"
     * }
     */
    public function show(Request $request, int $employee_id)
    {
        $validator = Validator::make(
            array_merge($request->all(), ['employee_id' => $employee_id]),
            [
                'employee_id' => 'required|integer|exists:employees,id',
                'year'        => 'required|integer|min:2020|max:2099',
                'month'       => 'required|integer|min:1|max:12',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $this->query->getBreakdownByEmployee(
            $employee_id,
            (int) $request->year,
            (int) $request->month
        );

        if (isset($data['error'])) {
            return response()->json(['message' => $data['error']], 404);
        }

        return response()->json($data);
    }
}
