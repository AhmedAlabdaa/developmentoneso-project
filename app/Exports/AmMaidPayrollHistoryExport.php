<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AmMaidPayrollHistoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected Collection $rows;

    public function __construct(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function collection(): Collection
    {
        return $this->rows->map(static function ($row) {
            return [
                $row->employee_name,
                $row->passport_no,
                $row->nationality,
                $row->period,
                (int) ($row->total_days ?? 0),
                (float) ($row->total_salary ?? 0),
                (float) ($row->deductions ?? 0),
                (float) ($row->allowance ?? 0),
                (float) ($row->net_salary ?? 0),
                $row->payment_method,
                $row->payment_note,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'NAME OF EMPLOYEE',
            'PASSPORT NO',
            'NATIONALITY',
            'PERIOD',
            'TOTAL DAYS',
            'TOTAL SALARY',
            'DEDUCTIONS',
            'ALLOWANCE',
            'NET SALARY',
            'PAYMENT METHOD',
            'PAYMENT NOTE',
        ];
    }
}
