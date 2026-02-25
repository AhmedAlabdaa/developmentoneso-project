<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class LiveSalaryExport implements FromArray, WithHeadings
{
    protected array $rows;

    public function __construct(array $data)
    {
        $this->rows = $data['rows'];
    }

    public function array(): array
    {
        $export = [];
        foreach ($this->rows as $r) {
            $export[] = [
                $r['CN'],
                $r['name'],
                Carbon::parse($r['contractCreated'])->format('j F Y'),
                $r['nationality'],
                $r['package'],
                Carbon::parse($r['contractStart'])->format('j M Y'),
                Carbon::parse($r['contractEnd'])->format('j M Y'),
                $r['duration'],
                $r['basic'],
                $r['calculated'],
            ];
        }
        return $export;
    }

    public function headings(): array
    {
        return [
            'Reference No',
            'Employee Name',
            'Contract Date',
            'Nationality',
            'Package',
            'Cont. Start Date',
            'Cont. End Date',
            'Duration',
            'Net Salary',
            'Calculated Salary',
        ];
    }
}
