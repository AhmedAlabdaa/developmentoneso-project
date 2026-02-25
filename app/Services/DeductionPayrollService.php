<?php

namespace App\Services;

use App\Models\DeductionPayroll;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeductionPayrollService
{
    public function create(array $data): DeductionPayroll
    {
        $record = DeductionPayroll::create([
            'deduction_date' => $data['deduction_date'] ?? null,
            'employee_id' => $data['employee_id'],
            'payroll_year' => $data['payroll_year'],
            'payroll_month' => $data['payroll_month'],
            'amount_deduction' => $data['amount_deduction'] ?? 0,
            'amount_allowance' => $data['amount_allowance'] ?? 0,
            'note' => $data['note'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return $record->refresh()->load(['employee', 'createdBy', 'updatedBy']);
    }

    public function createMany(array $rows): Collection
    {
        return DB::transaction(function () use ($rows) {
            $records = new Collection();

            foreach ($rows as $row) {
                $records->push($this->create($row));
            }

            return $records;
        });
    }

    public function update(DeductionPayroll $record, array $data): DeductionPayroll
    {
        $record->update(array_merge($data, [
            'updated_by' => auth()->id(),
        ]));

        return $record->refresh()->load(['employee', 'createdBy', 'updatedBy']);
    }

    public function delete(DeductionPayroll $record): bool
    {
        return (bool) $record->delete();
    }
}
