<?php

namespace App\Http\Controllers;

use App\Http\Resources\TrialBalanceResource;
use App\Queries\TrialBalanceQuery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @group Trial Balance
 *
 * APIs for retrieving trial balance report data.
 */
class TrialBalanceController extends Controller
{
    /**
     * Get Trial Balance
     *
     * Retrieve a trial balance report with ledger accounts organized by class, group, and sub-class.
     * Each ledger shows total debits, total credits, closing balance, and balance type (DR/CR).
     * Ledgers with zero closing balance are excluded.
     *
     * @queryParam posting_date_from date Filter from posting date (Y-m-d). Example: 2026-01-01
     * @queryParam posting_date_to date Filter to posting date (Y-m-d). Example: 2026-01-31
     * @queryParam spacial integer Filter by spacial type (e.g., 3 for Customer). Example: 3
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['posting_date_from', 'posting_date_to', 'spacial']);

        $query = new TrialBalanceQuery();
        
        $results = $query
            ->applyFilters($filters)
            ->excludeZeroBalances()
            ->orderByHierarchy()
            ->get();

        // Calculate summary totals
        $totalDr = 0;
        $totalCr = 0;

        foreach ($results as $row) {
            $closingBalance = (float) $row->closing_balance;
            if ($closingBalance >= 0) {
                $totalDr += abs($closingBalance);
            } else {
                $totalCr += abs($closingBalance);
            }
        }

        return response()->json([
            'data' => TrialBalanceResource::collection($results),
            'summary' => [
                'total_dr' => number_format($totalDr, 2, '.', ''),
                'total_cr' => number_format($totalCr, 2, '.', ''),
                'is_balanced' => abs($totalDr - $totalCr) < 0.01,
            ],
        ]);
    }
}
