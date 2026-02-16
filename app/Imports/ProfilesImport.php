<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\Sponsor;
use App\Models\Supplier;
use App\Models\FinanceHistory;
use App\Models\TravellingHistory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProfilesImport implements ToCollection, WithHeadingRow
{
    private $totalProfiles = 0;
    private $processedProfiles = 0;
    private $errors = [];

    public function collection(Collection $rows)
    {
        $this->totalProfiles = $rows->count() - 1;

        $rows = $rows->slice(1);

        foreach ($rows as $row) {
            try {
                $data = $row->toArray();

                if (empty($data['full_name']) || empty($data['pp'])) {
                    $this->errors[] = "Missing required fields in row: " . json_encode($data);
                    continue;
                }

                $passportNumber = $data['pp'];
                $existingProfile = Profile::where('passport_number', $passportNumber)->first();
                if ($existingProfile) {
                    $this->errors[] = "Profile already exists for passport number: $passportNumber";
                    continue;
                }

                $profile = Profile::create([
                    'name' => $data['full_name'],
                    'slug' => Str::slug($data['full_name']),
                    'nationality' => $data['nationality'] ?? '',
                    'web_status' => $data['status'] ?? '',
                    'current_working_status' => $data['current'] ?? '',
                    'sales' => $data['sales'] ?? '',
                    'passport_number' => $passportNumber,
                    'passport_expiry_date' => $this->transformDate($data['pp_exp']) ?? null,
                    'date_of_birth' => $this->transformDate($data['dob']) ?? null,
                    'visa_type' => $data['visa'] ?? '',
                    'arrival_date' => $this->transformDate($data['arrival_date']) ?? null,
                    'cancel_date' => $this->transformDate($data['cancel_date']) ?? null,
                ]);

                $companyId = session('company_id');
                if (!empty($companyId)) {
                    $profile['company_id'] = $companyId;
                }

                if (!empty($data['supplier']) && $data['supplier'] != "N/A") {
                    Supplier::create([
                        'profile_id' => $profile->id,
                        'supplier_name' => $data['supplier'],
                    ]);
                }

                if (!empty($data['spo_name']) && $data['spo_name'] != "N/A") {
                    Sponsor::firstOrCreate([
                        'profile_id' => $profile->id,
                        'sponsor_name' => $data['spo_name'],
                        'sponsor_id' => $data['spo_id'] ?? null,
                    ]);
                }

                if (!empty($data['overstay_days']) && $data['overstay_days'] != "N/A") {
                    FinanceHistory::create([
                        'profile_id' => $profile->id,
                        'overstay_days' => $data['overstay_days'],
                        'fine' => $data['fines'] ?? null,
                        'finance_date' => now(),
                    ]);
                }

                if (!empty($data['arrival_date']) && $data['arrival_date'] != "N/A") {
                    TravellingHistory::create([
                        'profile_id' => $profile->id,
                        'arrival_date' => $this->transformDate($data['arrival_date']),
                        'return_date' => $this->transformDate($data['return_date']) ?? null,
                    ]);
                }

                $this->processedProfiles++;
            } catch (\Exception $e) {
                $this->errors[] = 'Error processing row: ' . $e->getMessage() . ' | Data: ' . json_encode($row->toArray());
            }
        }
    }

    private function transformDate($date, $format = 'd-M-y')
    {
        try {
            return Carbon::createFromFormat($format, $date)->format('Y-m-d');
        } catch (\Exception $e) {
            $this->errors[] = 'Error transforming date: ' . $e->getMessage() . ' | Date: ' . $date;
            return null;
        }
    }

    public function getTotalProfiles()
    {
        return $this->totalProfiles;
    }

    public function getProcessedProfiles()
    {
        return $this->processedProfiles;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
