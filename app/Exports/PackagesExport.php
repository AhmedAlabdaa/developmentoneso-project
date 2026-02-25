<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PackagesExport implements FromCollection, WithHeadings
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
            if ($this->status === 'office') {
                return [
                    $item->CN_Number,
                    $item->candidate_name,
                    $item->category,
                    $item->returned_date,
                    $item->expiry_date,
                    $item->overstay_days,
                    $item->fine_amount,
                    $item->passport_status
                ];
            }

            return [
                $item->CN_Number,
                $item->sales_name,
                $item->candidate_name,
                $item->foreign_partner,
                $item->current_status,
                $item->passport_no,
                $item->passport_expiry,
                $item->dob,
                $item->uae_branch,
                $item->visa_type,
                $item->CL_Number,
                $item->sponsor_name,
                $item->eid_no,
                $item->nationality,
                $item->client_nationality,
                $item->wc_date,
                $item->dw_number,
                $item->visa_date,
                $item->incident_type,
                $item->incident_date,
                $item->arrived_date,
                $item->package,
                $item->sales_communication_status,
                $item->missing_files,
                $item->remark
            ];
        });
    }

    public function headings(): array
    {
        if ($this->status === 'office') {
            return [
                'CN Number', 'Candidate Name', 'Category', 'Returned Date',
                'Expiry Date', 'Overstay Days', 'Fine Amount', 'Passport Status'
            ];
        }

        return [
            'CN Number', 'Sales Name', 'Candidate Name', 'Foreign Partner', 'Current Status',
            'Passport Number', 'Passport Expiry Date', 'Date of Birth', 'Branch (UAE)',
            'Visa Type', 'Client Number', 'Sponsor Name', 'EID Number', 'Nationality',
            'Client Nationality', 'WC Date', 'DW Number', 'Visa Date', 'Incident Type',
            'Incident Date', 'Arrived Date', 'Package', 'Sales Comm. Status',
            'Missing Files', 'Remark'
        ];
    }
}
