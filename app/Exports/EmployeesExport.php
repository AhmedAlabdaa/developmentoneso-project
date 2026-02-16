<?php

namespace App\Exports;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected array $filters;

    protected array $visaStageNames = [
        1  => 'Visit 1',
        2  => 'Visit 2',
        3  => 'Dubai Insurance',
        4  => 'Entry Permit Visa',
        5  => 'CS (For Inside)',
        6  => 'Medical',
        7  => 'Tawjeeh Date',
        8  => 'EID',
        9  => 'Residence Visa Stamping',
        10 => 'Visit 3',
        11 => 'ILOE',
        12 => 'Salary Details',
        13 => 'Visa Cancellation',
        14 => 'Completed',
        15 => 'Arrived',
    ];

    protected array $trialStatusNames = [
        1 => 'Pending',
        2 => 'Active',
        3 => 'Exceeded',
        4 => 'Rejected',
        5 => 'Contracted',
        6 => 'Extended',
    ];

    protected array $insideStatusNames = [
        1 => 'Office',
        2 => 'Contracted',
        3 => 'Incidented',
    ];

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;

        $dbStages = DB::table('process_flow_steps')->pluck('title', 'id')->toArray();
        if (!empty($dbStages)) {
            $this->visaStageNames = $dbStages + $this->visaStageNames;
        }
    }

    public function collection(): Collection
    {
        $status  = $this->filters['status'] ?? 'all';
        $package = $this->filters['searchPackage'] ?? null;

        $q = Employee::query()->select('employees.*');

        if ($status === 'trial') {
            $q->leftJoin('agreements', function ($j) {
                    $j->on(
                        DB::raw('agreements.passport_no COLLATE utf8mb4_unicode_ci'),
                        '=',
                        DB::raw('employees.passport_no COLLATE utf8mb4_unicode_ci')
                    );
                })
              ->leftJoin('contracts', 'contracts.agreement_reference_no', '=', 'agreements.reference_no')
              ->addSelect([
                  'agreements.candidate_name as agreement_candidate_name',
                  'agreements.passport_no as agreement_passport_no',
                  'agreements.nationality as agreement_nationality',
                  'agreements.foreign_partner as agreement_foreign_partner',
                  'agreements.package as agreement_package',
                  'agreements.visa_status as agreement_visa_status',
                  'contracts.status as contract_status',
              ])
              ->where('employees.inside_status', 2);
        }

        if ($status === 'office') $q->where('employees.inside_status', 1);
        if ($status === 'incident') $q->where('employees.inside_status', 3);
        if ($status === 'outside') $q->where('employees.inside_country_or_outside', 1);

        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $q->where(function ($qq) use ($s) {
                $qq->where('employees.reference_no', 'like', "%{$s}%")
                   ->orWhere('employees.name', 'like', "%{$s}%")
                   ->orWhere('employees.passport_no', 'like', "%{$s}%");
            });
        }

        if (!empty($this->filters['searchRef'])) {
            $q->where('employees.reference_no', 'like', $this->filters['searchRef'] . '%');
        }

        if (($this->filters['status'] ?? '') === 'trial' && !empty($this->filters['searchRefCont'])) {
            $q->where('contracts.reference_no', 'like', $this->filters['searchRefCont'] . '%');
        }

        if (!empty($this->filters['searchName'])) {
            $q->where('employees.name', 'like', $this->filters['searchName'] . '%');
        }

        if (!empty($this->filters['searchPassport'])) {
            $q->where('employees.passport_no', 'like', $this->filters['searchPassport'] . '%');
        }

        if (!empty($this->filters['searchPartner'])) {
            $q->where('employees.foreign_partner', 'like', '%' . $this->filters['searchPartner'] . '%');
        }

        if (!empty($this->filters['searchVisaStage'])) {
            $q->where('employees.visa_status', $this->filters['searchVisaStage']);
        }

        if (!empty($this->filters['searchNationality'])) {
            $q->where('employees.nationality', $this->filters['searchNationality']);
        }

        if (!empty($package)) {
            $q->where('employees.package', $package);
        }

        if (!empty($this->filters['searchCategory'])) {
            $q->where('employees.category', $this->filters['searchCategory']);
        }

        if (!empty($this->filters['searchTrial']) && ($this->filters['status'] ?? '') === 'trial') {
            $q->where('contracts.status', $this->filters['searchTrial']);
        }

        if (!empty($this->filters['searchIncident'])) {
            $q->where('employees.incident_type', $this->filters['searchIncident']);
        }

        $q->orderByDesc('employees.reference_no');

        return $q->distinct()->get();
    }

    protected function fmtDate($v): string
    {
        if (!$v) return '';
        try { return Carbon::parse($v)->format('Y-m-d'); } catch (\Throwable $e) { return (string) $v; }
    }

    protected function fmtDateTime($v): string
    {
        if (!$v) return '';
        try { return Carbon::parse($v)->format('Y-m-d H:i'); } catch (\Throwable $e) { return (string) $v; }
    }

    protected function shortForeignPartner(?string $v): string
    {
        $v = trim((string) $v);
        if ($v === '') return '';
        $parts = preg_split('/\s+/', $v);
        $first = $parts[0] ?? '';
        return trim($first);
    }

    protected function stageName($employee): string
    {
        $raw = $employee->visa_status ?? $employee->agreement_visa_status ?? null;
        if ($raw === null || $raw === '' || (int)$raw === 0) return 'Not started';
        $id = (int) $raw;
        return $this->visaStageNames[$id] ?? (string) $id;
    }

    protected function statusName($employee): string
    {
        $statusFilter = $this->filters['status'] ?? 'all';

        if ($statusFilter === 'trial') {
            $raw = $employee->contract_status ?? $employee->trial_status ?? null;
            if ($raw === null || $raw === '' || (int)$raw === 0) return 'No Status';
            $id = (int) $raw;
            return $this->trialStatusNames[$id] ?? (string) $id;
        }

        $raw = $employee->inside_status ?? null;
        if ($raw === null || $raw === '' || (int)$raw === 0) return 'No Status';
        $id = (int) $raw;
        return $this->insideStatusNames[$id] ?? (string) $id;
    }

    public function map($employee): array
    {
        $name          = $employee->name ?: ($employee->agreement_candidate_name ?? '');
        $passportNo     = $employee->passport_no ?: ($employee->agreement_passport_no ?? '');
        $nationality    = $employee->nationality ?: ($employee->agreement_nationality ?? '');
        $foreignPartner = $employee->foreign_partner ?: ($employee->agreement_foreign_partner ?? '');
        $package        = $employee->package ?: ($employee->agreement_package ?? '');
        $visaStage      = $this->stageName($employee);
        $statusText     = $this->statusName($employee);

        return [
            $employee->reference_no ?? '',
            $this->fmtDateTime($employee->created_at ?? null),
            $visaStage,
            $this->fmtDate($employee->expiry_date ?? ($employee->visa_expiry_date ?? null)),
            $statusText,
            $name,
            $passportNo,
            $nationality,
            $this->shortForeignPartner($foreignPartner),
            $package,
            $this->fmtDate($employee->passport_expiry_date ?? ($employee->p_exp_date ?? null)),
            $this->fmtDate($employee->passport_issue_date ?? null),
            $this->fmtDate($employee->date_of_joining ?? ($employee->doj ?? null)),
            $employee->visa_designation ?? ($employee->visa_desig ?? ''),
            $this->fmtDate($employee->date_of_birth ?? ($employee->dob ?? null)),
            $employee->gender ?? '',
            $this->fmtDate($employee->employment_contract_start_date ?? ($employee->start_date ?? null)),
            $this->fmtDate($employee->employment_contract_end_date ?? ($employee->end_date ?? null)),
            $employee->contract_type ?? ($employee->type ?? ''),
            $employee->salary_as_per_contract ?? ($employee->contract_salary ?? ($employee->cont_salary ?? '')),
            $employee->basic ?? ($employee->basic_salary ?? ''),
            $employee->housing ?? ($employee->housing_allowance ?? ($employee->housing_allow ?? '')),
            $employee->transport ?? ($employee->transport_allowance ?? ($employee->transport_allow ?? '')),
            $employee->other_allowances ?? ($employee->other_allowance ?? ($employee->other_allow ?? '')),
            $employee->total_salary ?? '',
            $employee->payment_type ?? '',
            $employee->bank_name ?? '',
            $employee->iban ?? '',
            $employee->remarks ?? '',
            $employee->comments ?? '',
        ];
    }

    public function headings(): array
    {
        return [
            'Ref #',
            'Created At',
            'Visa Stage',
            'Expiry Date',
            'Status',
            'Name',
            'Passport No',
            'Nationality',
            'Foreign Partner',
            'Package',
            'P.Exp. Date',
            'Passport Issue Date',
            'DOJ',
            'Visa Desig.',
            'Date of Birth',
            'Gender',
            'Start Date',
            'End Date',
            'Type',
            'Cont. Salary',
            'Basic Salary',
            'Housing Allow.',
            'Transport Allow.',
            'Other Allow',
            'Total Salary',
            'Payment Type',
            'Bank Name',
            'IBAN',
            'Remarks',
            'Comments',
        ];
    }
}
