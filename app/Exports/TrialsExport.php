<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrialsExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $status;

    public function __construct($data, $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            return [
                $item->reference_no,
                $item->candidate_name,
                $item->trial_type,
                $item->client_id,
                $item->CL_Number,
                $item->CN_Number,
                $item->trial_start_date,
                $item->trial_end_date,
                $item->number_of_days,
                $item->package,
                $item->trial_status,
                $item->active_date,
                $item->confirmed_date,
                $item->change_status_date,
                $item->sales_return_date,
                $item->incident_date,
                $item->incident_type,
                $item->agreement_reference_no,
                $item->agreement_amount,
                $item->remarks
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Reference No', 'Candidate Name', 'Trial Type', 'Client ID', 'CL Number', 'CN Number',
            'Trial Start Date', 'Trial End Date', 'Number of Days', 'Package', 'Trial Status',
            'Active Date', 'Confirmed Date', 'Change Status Date', 'Sales Return Date',
            'Incident Date', 'Incident Type', 'Agreement Reference No', 'Agreement Amount', 'Remarks'
        ];
    }
}
