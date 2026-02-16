<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AgreementsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected Collection $rows;

    public function __construct(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function collection(): Collection
    {
        return $this->rows->map(fn($agreement) => [
            $agreement->reference_no,
            $agreement->candidate_name,
            match ($agreement->status) {
                1 => 'Pending',
                2 => 'Active',
                3 => 'Exceeded',
                4 => 'Cancelled',
                5 => 'Contracted',
                6 => 'Rejected',
                default => 'Unknown',
            },

            trim(optional($agreement->client)->first_name . ' ' . optional($agreement->client)->last_name),
            $agreement->agreement_start_date
                ? Carbon::parse($agreement->agreement_start_date)->format('Y-m-d')
                : '',
            $agreement->agreement_end_date
                ? Carbon::parse($agreement->agreement_end_date)->format('Y-m-d')
                : '',
            $agreement->foreign_partner,
            number_format($agreement->total_amount, 2),
            number_format($agreement->received_amount, 2),
            number_format($agreement->remaining_amount, 2),
            trim(optional($agreement->user)->first_name . ' ' . optional($agreement->user)->last_name),
            Carbon::parse($agreement->created_at)->format('Y-m-d H:i:s'),
            $agreement->package,
            $agreement->agreement_type,
        ]);
    }

    public function headings(): array
    {
        return [
            'Reference No',
            'Candidate Name',
            'Status',
            'Sponsor Name',
            'Agreement Start Date',
            'Agreement End Date',
            'Partner',
            'Total Amount',
            'Received Amount',
            'Balance',
            'Sales Name',
            'Created Date',
            'Package',
            'Agreement Type',
        ];
    }
}
