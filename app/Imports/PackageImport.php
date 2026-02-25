<?php

namespace App\Imports;

use App\Models\Package;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class PackageImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            Validator::make($row, [
                'passport_no' => 'required|unique:packages,passport_no',
                'sales_name' => 'required',
                'candidates_name' => 'required',
            ])->validate();

            $passportExpiryDate = $this->convertExcelDate($row['pp_expiry_date'] ?? null);
            $visaDate = $this->convertExcelDate($row['visa_date'] ?? null);
            $wcDate = $this->convertExcelDate($row['wc_date'] ?? null);
            $incidentDate = $this->convertExcelDate($row['incident_date'] ?? null);
            $arrivedDate = $this->convertExcelDate($row['arrived_date'] ?? null);

            return new Package([
                'hr_ref_no' => $row['hr_ref_no'] ?? null,
                'CN_Number' => $this->generateCN(),
                'contract_no' => $row['ct_no'] ?? null,
                'agreement_no' => null,
                'sales_name' => $row['sales_name'] ?? null,
                'candidate_name' => $row['candidates_name'] ?? null,
                'passport_no' => $row['passport_no'] ?? null,
                'passport_expiry_date' => $passportExpiryDate,
                'branch_in_uae' => $row['branch_in_uae'] ?? null,
                'visa_type' => $row['visa_type'] ?? null,
                'CL_Number' => $row['cl_no'] ?? null,
                'sponsor_name' => $row['sponsor_name'] ?? null,
                'eid_no' => $row['eid_no'] ?? null,
                'nationality' => $row['nationality'] ?? null,
                'wc_date' => $wcDate,
                'dw_number' => $row['dw_number'] ?? null,
                'visa_date' => $visaDate,
                'incident_type' => $row['incident_type'] ?? null,
                'incident_date' => $incidentDate,
                'arrived_date' => $arrivedDate,
                'package' => null,
                'sales_comm_status' => $row['sales_comm_status'] ?? null,
                'remark' => $row['remark'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (ValidationException $e) {
            \Log::error('Validation Error at Row: ' . json_encode($row));
            throw $e;
        } catch (\Exception $e) {
            \Log::error('General Error at Row: ' . json_encode($row) . ' Error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function convertExcelDate($dateValue)
    {
        if (is_numeric($dateValue)) {
            return Date::excelToDateTimeObject($dateValue)->format('Y-m-d');
        }
        if (strtotime($dateValue)) {
            return date('Y-m-d', strtotime($dateValue));
        }
        return null;
    }

    private function generateCN()
    {
        $cnCounter = Package::count() + 1;
        return 'CN-' . str_pad($cnCounter, 4, '0', STR_PAD_LEFT);
    }
}
