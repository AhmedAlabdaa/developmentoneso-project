<?php

namespace App\Http\Controllers;

use App\Queries\AmInstallmentQuery;
use App\Services\AmInstallmentService;
use Illuminate\Http\Request;
use Exception;

/**
 * @group Package 3 Modular
 * @subgroup Installments
 *
 * APIs for managing contract installments.
 */
class AmInstallmentController extends Controller
{
    protected $query;
    protected $service;

    public function __construct(AmInstallmentQuery $query, AmInstallmentService $service)
    {
        $this->query = $query;
        $this->service = $service;
    }

    /**
     * List installments.
     *
     * Returns a paginated list of installments with optional filters.
     *
     * @queryParam per_page integer Number of items per page. Default: 15. Example: 20
     * @queryParam sort_by string Sort field (id, date, amount, status, created_at). Default: date. Example: amount
     * @queryParam sort_direction string Sort direction (asc, desc). Default: desc. Example: asc
     * @queryParam am_movment_id integer Filter by contract movement ID. Example: 3
     * @queryParam contract_id integer Filter by primary contract ID. Example: 1
     * @queryParam employee_id integer Filter by employee/maid ID. Example: 5
     * @queryParam employee_name string Filter by employee/maid name. Example: Maria
     * @queryParam customer_name string Filter by customer name (first or last). Example: Ahmed
     * @queryParam crm_id integer Filter by customer (CRM) ID. Example: 1
     * @queryParam status integer Filter by status (0 = pending, 1 = invoiced). Example: 0
     * @queryParam date_from string Filter installments from this date. Example: 2026-01-01
     * @queryParam date_to string Filter installments until this date. Example: 2026-12-31
     * @queryParam search string Search by note. Example: salary
     *
     * @response 200 {
     *   "current_page": 1,
     *   "data": [
     *     {
     *       "id": 1,
     *       "date": "2026-03-01",
     *       "amount": 1000,
     *       "status": 0,
     *       "note": "First installment",
     *       "contract_movment": {}
     *     }
     *   ],
     *   "last_page": 1,
     *   "per_page": 15,
     *   "total": 1
     * }
     */
    public function index(Request $request)
    {
        $installments = $this->query->getInstallments(
            $request->only([
                'am_movment_id',
                'contract_id',
                'employee_id',
                'employee_name',
                'customer_name',
                'crm_id',
                'status',
                'date_from',
                'date_to',
                'search',
                'sort_by',
                'sort_direction',
            ]),
            $request->input('per_page', 15)
        );

        return response()->json($installments);
    }
}
