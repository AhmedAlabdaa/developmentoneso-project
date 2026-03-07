<?php

namespace App\Services;

use App\Models\AmMaidPayRoll;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AmMaidPayRollHistoryService
{
    public function createManyByRows(array $data): Collection
    {
        return DB::transaction(function () use ($data) {
            $employeeIds = collect($data['rows'])
                ->pluck('employee_id')
                ->unique()
                ->values()
                ->all();

            $existingEmployeeIds = AmMaidPayRoll::query()
                ->where('year', $data['year'])
                ->where('month', $data['month'])
                ->whereIn('employee_id', $employeeIds)
                ->pluck('employee_id')
                ->all();

            if (!empty($existingEmployeeIds)) {
                throw ValidationException::withMessages([
                    'rows' => [
                        'Payroll history already exists for employee ids: ' . implode(', ', $existingEmployeeIds) . ' in ' . $data['year'] . '-' . str_pad((string) $data['month'], 2, '0', STR_PAD_LEFT),
                    ],
                ]);
            }

            $records = new Collection();

            foreach ($data['rows'] as $row) {
                $record = AmMaidPayRoll::create([
                    'employee_id' => $row['employee_id'],
                    'year' => $data['year'],
                    'month' => $data['month'],
                    'payment_method' => $row['payment_method'] ?? null,
                    'basic_salary' => $row['basic_salary'] ?? 0,
                    'deduction' => $row['deduction'] ?? 0,
                    'allowance' => $row['allowance'] ?? 0,
                    'net' => $row['net'] ?? 0,
                    'note' => $data['note'] ?? null,
                    'paid_at' => $row['paid_at'] ?? null,
                    'status' => $row['status'] ?? 'draft',
                    'created_by' => auth()->id(),
                ]);

                $records->push($record->refresh()->load(['employee', 'createdBy', 'updatedBy']));
            }

            return $records;
        });
    }

    public function update(AmMaidPayRoll $record, array $data): AmMaidPayRoll
    {
        $record->update(array_merge($data, [
            'updated_by' => auth()->id(),
        ]));

        return $record->refresh()->load(['employee', 'createdBy', 'updatedBy']);
    }

    public function delete(AmMaidPayRoll $record): bool
    {
        return (bool) $record->delete();
    }
}
