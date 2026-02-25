<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContractsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected Collection $rows;

    public function __construct(Collection $rows)
    {
        $this->rows = $rows;
    }

    public function collection(): Collection
    {
        return $this->rows->map(fn($contract) => [
            $contract->reference_no,
            $contract->agreement_candidate_name,
            trim(optional($contract->client)->first_name . ' ' . optional($contract->client)->last_name),
            $contract->contract_start_date
                ? Carbon::parse($contract->contract_start_date)->format('Y-m-d')
                : '',
            $contract->contract_end_date
                ? Carbon::parse($contract->contract_end_date)->format('Y-m-d')
                : '',
            $contract->maid_delivered,
            Carbon::parse($contract->created_at)->format('Y-m-d H:i:s'),
            $contract->agreement_package,
            $contract->agreement_type,
        ]);
    }

    public function headings(): array
    {
        return [
            'Reference No',
            'Candidate Name',
            'Sponsor Name',
            'Contract Start Date',
            'Contract End Date',
            'Maid Transferred',
            'Created At',
            'Package',
            'Contract Type',
        ];
    }
}
