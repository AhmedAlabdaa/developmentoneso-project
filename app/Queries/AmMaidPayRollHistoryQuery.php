<?php

namespace App\Queries;

use App\Models\AmMaidPayRoll;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AmMaidPayRollHistoryQuery
{
    public function getPayrollHistories(array $filters = [], int $perPage = 15)
    {
        $query = AmMaidPayRoll::with(['employee', 'createdBy', 'updatedBy']);

        if (!empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (!empty($filters['year'])) {
            $query->where('year', $filters['year']);
        }

        if (!empty($filters['month'])) {
            $query->where('month', $filters['month']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('note', 'like', "%{$search}%")
                    ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('passport_no', 'like', "%{$search}%")
                            ->orWhere('emirates_id', 'like', "%{$search}%")
                            ->orWhere('reference_no' , 'like' ,"%{$search}%" );
                    });
            });
        }

        $sortBy = $filters['sort_by'] ?? 'id';
        $sortDir = $filters['sort_direction'] ?? 'desc';
        $allowedSorts = ['id', 'year', 'month', 'net', 'basic_salary', 'created_at'];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        if (!in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        return $query->orderBy($sortBy, $sortDir)->paginate($perPage);
    }

    public function getById(int $id): AmMaidPayRoll
    {
        return AmMaidPayRoll::with(['employee', 'createdBy', 'updatedBy'])->findOrFail($id);
    }

    public function getExportRows(int $year, int $month): Collection
    {
        $monthStart = Carbon::create($year, $month, 1)->startOfDay()->toDateString();
        $monthEnd = Carbon::create($year, $month, 1)->endOfMonth()->toDateString();

        $startExpr = "GREATEST(m.date, '{$monthStart}')";
        $endExpr = "LEAST(COALESCE(r.date, '{$monthEnd}'), '{$monthEnd}')";
        $startDayExpr = "LEAST(DAY({$startExpr}), 30)";
        $endDayExpr = "CASE
            WHEN {$endExpr} = '{$monthEnd}' THEN 30
            ELSE LEAST(DAY({$endExpr}), 30)
        END";
        $workingDaysExpr = "GREATEST(({$endDayExpr}) - ({$startDayExpr}) + 1, 0)";

        $workingDaysSubQuery = DB::table('am_contract_movments as m')
            ->leftJoin('am_return_maids as r', 'r.am_movment_id', '=', 'm.id')
            ->where('m.date', '<=', $monthEnd)
            ->where(function ($q) use ($monthStart) {
                $q->whereNull('r.date')
                    ->orWhere('r.date', '>=', $monthStart);
            })
            ->select([
                'm.employee_id',
                DB::raw("SUM({$workingDaysExpr}) as total_days"),
            ])
            ->groupBy('m.employee_id');

        return DB::table('am_maid_pay_rolls as pr')
            ->join('employees as e', 'e.id', '=', 'pr.employee_id')
            ->leftJoinSub($workingDaysSubQuery, 'wd', function ($join) {
                $join->on('wd.employee_id', '=', 'pr.employee_id');
            })
            ->where('pr.year', $year)
            ->where('pr.month', $month)
            ->select([
                'e.name as employee_name',
                'e.passport_no',
                'e.nationality',
                DB::raw("CONCAT(pr.year, '-', LPAD(pr.month, 2, '0')) as period"),
                DB::raw('COALESCE(wd.total_days, 0) as total_days'),
                'e.total_salary',
                'pr.deduction as deductions',
                'pr.allowance',
                'pr.net as net_salary',
                'pr.payment_method',
                'pr.note as payment_note',
            ])
            ->orderBy('e.name')
            ->get();
    }
}
