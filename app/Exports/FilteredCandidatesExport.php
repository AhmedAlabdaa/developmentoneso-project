<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class FilteredCandidatesExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Ref No',
            'Candidate Name',
            'Passport No',
            'Passport Expiry Date',
            'Nationality',
            'Current Status',
            'Foreign Partner',
            'Religion',
            'Marital Status',
        ];
    }

    public function map($row): array
    {
        return [
            (string) $row->ref_no,
            (string) $row->candidate_name,
            (string) $row->passport_no,
            $this->fmtDate($row->passport_expiry_date),
            $this->countryName($row->nationality_name, (int) $row->nationality),
            $this->statusName($row->current_status_name, (int) $row->current_status),
            (string) ($row->foreign_partner ?? ''),
            (string) ($row->religion ?? ''),
            $this->maritalStatusLabel($row->marital_status),
        ];
    }

    protected function fmtDate($val): string
    {
        if (!$val) return '';
        try { return \Carbon\Carbon::parse($val)->format('Y-m-d'); }
        catch (\Throwable) { return (string) $val; }
    }

    protected function maritalStatusLabel($code): string
    {
        return match ((string) $code) {
            '1' => 'Single',
            '2' => 'Married',
            '3' => 'Divorced',
            '4' => 'Widowed',
            default => '',
        };
    }

    protected function countryName(?string $dbName, int $id): string
    {
        if ($dbName && trim($dbName) !== '') return $dbName;
        $fallback = [
            1 => 'Ethiopia',
            2 => 'Uganda',
            3 => 'Philippines',
            4 => 'Indonesia',
            5 => 'Sri Lanka',
            6 => 'Myanmar',
        ];
        return $fallback[$id] ?? '';
    }

    protected function statusName(?string $dbName, int $id): string
    {
        if ($dbName && trim($dbName) !== '') return $dbName;
        $fallback = [
            1  => 'Available',
            2  => 'Back Out',
            3  => 'Hold',
            4  => 'Selected',
            5  => 'WC-Date',
            6  => 'Incident Before Visa (IBV)',
            7  => 'Visa Date',
            8  => 'Incident After Visa (IAV)',
            9  => 'Medical Status',
            10 => 'COC-Status',
            11 => 'MoL Submitted Date',
            12 => 'MoL Issued Date',
            13 => 'Departure Date',
            14 => 'Incident After Departure (IAD)',
            15 => 'Arrived Date',
            16 => 'Incident After Arrival (IAA)',
            17 => 'Transfer Date',
        ];
        return $fallback[$id] ?? '';
    }
}
