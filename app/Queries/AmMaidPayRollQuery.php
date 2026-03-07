<?php

namespace App\Queries;

use App\Enum\EnumMaidStatus;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AmMaidPayRollQuery
{
    /**
     * Get salary calculation data for a given year and month.
     *
     * For each maid that was active during the month, returns:
     * - maid name, salary
     * - working_days (clamped to the month boundaries)
     * - last contract ID, last customer name
     *
     * @param int $year
     * @param int $month
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSalaryCalculation(int $year, int $month, int $perPage = 50)
    {
        $monthStart = Carbon::create($year, $month, 1)->startOfDay()->toDateString();
        $monthEnd   = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $deductionSubQuery = DB::table('deduction_payrolls')
            ->selectRaw('employee_id, SUM(amount_deduction) as total_deduction, MAX(note) as deduction_note,
             SUM(amount_allowance) as total_allowance')
            ->where('payroll_year', $year)
            ->where('payroll_month', $month)
            ->groupBy('employee_id');
        $startExpr  = "GREATEST(m.date, '{$monthStart}')";
        $endExpr    = "LEAST(COALESCE(r.date, '{$monthEnd}'), '{$monthEnd}')";
        $startDayExpr = "LEAST(DAY({$startExpr}), 30)";
        $endDayExpr = "CASE
            WHEN {$endExpr} = '{$monthEnd}' THEN 30
            ELSE LEAST(DAY({$endExpr}), 30)
        END";
        $workingDaysExpr = "
            GREATEST(({$endDayExpr}) - ({$startDayExpr}) + 1, 0)
        ";

        return DB::table('am_contract_movments as m')
            ->join('employees as e', 'e.id', '=', 'm.employee_id')
            ->join('am_primary_contracts as pc', 'pc.id', '=', 'm.am_contract_id')
            ->join('crm as c', 'c.id', '=', 'pc.crm_id')
            ->leftJoin('am_return_maids as r', 'r.am_movment_id', '=', 'm.id')
            ->leftJoin('am_maid_pay_rolls as pr', function ($join) use ($year, $month) {
                $join->on('pr.employee_id', '=', 'e.id')
                    ->where('pr.year', '=', $year)
                    ->where('pr.month', '=', $month);
            })
            ->leftJoinSub($deductionSubQuery, 'dp', function ($join) {
                $join->on('dp.employee_id', '=', 'e.id');
            })
            // Movement must have started on or before end of month
            ->where('m.date', '<=', $monthEnd)
            // And not returned before the start of month (still active during month)
            ->where(function ($q) use ($monthStart) {
                $q->whereNull('r.date')
                  ->orWhere('r.date', '>=', $monthStart);
            })
            ->select([
                'e.id as employee_id',
                'e.name as maid_name',
                'e.total_salary as maid_salary',
                'e.payment_type as method',
                DB::raw("
                    CASE e.inside_status
                        WHEN " . EnumMaidStatus::PENDING->value . " THEN '" . EnumMaidStatus::PENDING->label() . "'
                        WHEN " . EnumMaidStatus::OFFICE->value . " THEN '" . EnumMaidStatus::OFFICE->label() . "'
                        WHEN " . EnumMaidStatus::HIRED->value . " THEN '" . EnumMaidStatus::HIRED->label() . "'
                        WHEN " . EnumMaidStatus::INCIDENTED->value . " THEN '" . EnumMaidStatus::INCIDENTED->label() . "'
                        ELSE 'Unknown'
                    END as inside_status
                "),

                DB::raw("MAX(pc.id) as last_contract_id"),
                DB::raw("MAX(CONCAT(c.first_name, ' ', c.last_name)) as last_customer_name"),
                DB::raw("MAX(COALESCE(dp.total_deduction, 0)) as total_deduction"),
                DB::raw("MAX(COALESCE(dp.total_allowance, 0)) as total_allowance"),
                DB::raw("MAX(COALESCE(dp.deduction_note, '')) as deduction_note"),
                DB::raw("
                    CASE
                        WHEN MAX(pr.id) IS NULL THEN 'unpaid'
                        WHEN MAX(COALESCE(pr.status, '')) = 'paid' THEN 'paid'
                        ELSE 'unpaid'
                    END as payroll_status
                "),
                DB::raw("MAX(COALESCE(pr.note, '')) as payroll_note"),
                DB::raw("
                    ROUND(
                        (
                            ((e.total_salary / 30) * SUM({$workingDaysExpr}))
                            + MAX(COALESCE(dp.total_allowance, 0))
                            - MAX(COALESCE(dp.total_deduction, 0))
                        ),
                        2
                    ) as net_salary
                "),
                DB::raw("
                    SUM(
                        {$workingDaysExpr}
                    ) as working_days
                "),
            ])
            ->groupBy('e.id', 'e.name', 'e.total_salary')
            ->orderBy('e.name')
            ->paginate($perPage);
    }

    /**
     * Get breakdown details for a single employee in a given year/month.
     *
     * Returns every contract movement that overlaps the requested month,
     * together with the contract, customer, return info, and working days.
     *
     * @param int $employeeId
     * @param int $year
     * @param int $month
     * @return array
     */
    public function getBreakdownByEmployee(int $employeeId, int $year, int $month): array
    {
        $monthStart = Carbon::create($year, $month, 1)->startOfDay()->toDateString();
        $monthEnd   = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();
        $startExpr  = "GREATEST(m.date, '{$monthStart}')";
        $endExpr    = "LEAST(COALESCE(r.date, '{$monthEnd}'), '{$monthEnd}')";
        $startDayExpr = "LEAST(DAY({$startExpr}), 30)";
        $endDayExpr = "CASE
            WHEN {$endExpr} = '{$monthEnd}' THEN 30
            ELSE LEAST(DAY({$endExpr}), 30)
        END";
        $workingDaysExpr = "
            GREATEST(({$endDayExpr}) - ({$startDayExpr}) + 1, 0)
        ";

        $employee = DB::table('employees')
            ->where('id', $employeeId)
            ->select('id', 'name', 'total_salary', 'nationality', 'reference_no', 'payment_type')
            ->first();

        if (!$employee) {
            return ['error' => 'Employee not found'];
        }

        $movements = DB::table('am_contract_movments as m')
            ->join('am_primary_contracts as pc', 'pc.id', '=', 'm.am_contract_id')
            ->join('crm as c', 'c.id', '=', 'pc.crm_id')
            ->leftJoin('am_return_maids as r', 'r.am_movment_id', '=', 'm.id')
            // Movement started on or before end of month
            ->where('m.employee_id', $employeeId)
            ->where('m.date', '<=', $monthEnd)
            // Not returned before start of month
            ->where(function ($q) use ($monthStart) {
                $q->whereNull('r.date')
                  ->orWhere('r.date', '>=', $monthStart);
            })
            ->select([
                'm.id as movement_id',
                'm.date as movement_date',
                'm.note as movement_note',
                'm.status as movement_status',
                'pc.id as contract_id',
                DB::raw("CONCAT(c.first_name, ' ', c.last_name) as customer_name"),
                'c.cl as customer_cl',
                'r.id as return_id',
                'r.date as return_date',
                'r.note as return_note',
                DB::raw("
                    {$workingDaysExpr} as working_days
                "),
            ])
            ->orderBy('m.date')
            ->get();

        $totalWorkingDays = $movements->sum('working_days');
        $payrollAdjustments = DB::table('deduction_payrolls')
            ->where('employee_id', $employeeId)
            ->where('payroll_year', $year)
            ->where('payroll_month', $month)
            ->select([
                'id',
                'deduction_date',
                'amount_deduction',
                'amount_allowance',
                'note',
            ])
            ->orderByDesc('deduction_date')
            ->orderByDesc('id')
            ->get();
        $totalDeduction = (float) $payrollAdjustments->sum('amount_deduction');
        $totalAllowance = (float) $payrollAdjustments->sum('amount_allowance');
        $netSalary = round((((float) $employee->total_salary / 30) * (float) $totalWorkingDays) + $totalAllowance - $totalDeduction, 2);

        $payrollRecord = DB::table('am_maid_pay_rolls')
            ->where('employee_id', $employeeId)
            ->where('year', $year)
            ->where('month', $month)
            ->select('status', 'note')
            ->first();
            
        $payrollStatus = $payrollRecord ? ($payrollRecord->status ?: 'unpaid') : 'unpaid';
        $payrollNote = $payrollRecord ? ($payrollRecord->note ?: '') : '';
        $methodStr = $employee->payment_type ? ucfirst(strtolower($employee->payment_type)) : '-';

        return [
            'employee'           => $employee,
            'year'               => $year,
            'month'              => $month,
            'month_start'        => $monthStart,
            'month_end'          => $monthEnd,
            'movements'          => $movements,
            'total_working_days' => $totalWorkingDays,
            'payroll_adjustments' => $payrollAdjustments,
            'total_deduction'    => $totalDeduction,
            'total_allowance'    => $totalAllowance,
            'net_salary'         => $netSalary,
            'method'             => $methodStr,
            'payroll_status'     => $payrollStatus,
            'payroll_note'       => $payrollNote,
        ];
    }
}
