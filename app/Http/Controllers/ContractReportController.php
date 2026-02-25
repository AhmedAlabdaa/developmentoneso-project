<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ContractReportController extends Controller
{
    protected string $dateFormat = 'd M Y';

    public function __invoke(Request $request)
    {
        $package = $this->normalizePackage($request->query('package'));
        $statusFilter = $request->query('status');

        $filenameParts = ['mol-report'];
        if ($package) {
            $filenameParts[] = $package;
        }
        $filenameParts[] = now()->format('Ymd_His');
        $filename = implode('-', $filenameParts) . '.csv';

        $statusMap = [
            1 => 'Pending',
            2 => 'Active',
            3 => 'Exceeded',
            4 => 'Cancelled',
            5 => 'Contracted',
            6 => 'Rejected',
        ];

        $visaStatusMap = [
            0  => 'Not started',
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
        ];

        $baseQuery = Contract::query()
            ->with(['agreement', 'client', 'salesPerson', 'installments.items'])
            ->where('reference_no', 'like', 'CT-E%')
            ->when($package, fn ($q) => $q->where('package', $package))
            ->when($statusFilter !== null && $statusFilter !== '', fn ($q) => $q->where('status', $statusFilter));

        return Response::streamDownload(function () use ($baseQuery, $statusMap, $visaStatusMap) {
            $out = fopen('php://output', 'w');
            fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($out, [
                'Cont. #',
                'Sales Name',
                'Status',
                'Installments',
                'Date',
                'CN #',
                'CN Name',
                'Nationality (Contract)',
                'CL #',
                'Customer Name',
                'Contracted Amount',
                'Received',
                'Balance',
                'Package (Contract)',
                'Cont. Start',
                'Cont. End',
                'Delivered',
                'Transferred',
                'Contract Remarks',
                'Visa Status',
                'Passport No',
                'Passport Expiry Date',
                'Date of Joining',
                'Visa Designation',
                'Date of Birth',
                'Gender',
                'Maid Salary',
                'Basic',
                'Housing',
                'Transport',
                'Other Allowances',
                'Total Salary',
                'Payment Type',
                'Bank Name',
                'IBAN',
                'Employee Remarks',
                'Employee Comments',
            ]);

            (clone $baseQuery)
                ->orderBy('id')
                ->chunkById(500, function ($contracts) use ($out, $statusMap, $visaStatusMap) {
                    $rawPassports = $contracts
                        ->pluck('passport_no')
                        ->filter(fn ($p) => $p !== null && trim((string) $p) !== '')
                        ->map(fn ($p) => trim((string) $p))
                        ->unique()
                        ->values();

                    $normalizedPassports = $rawPassports
                        ->map(fn ($p) => $this->normalizePassport($p))
                        ->filter()
                        ->unique()
                        ->values();

                    $employees = $normalizedPassports->isEmpty()
                        ? collect()
                        : Employee::query()
                            ->whereIn(
                                DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(UPPER(passport_no),' ',''),'-',''),'/',''),'.','')"),
                                $normalizedPassports
                            )
                            ->get();

                    $employeesByPassport = $employees->keyBy(fn ($e) => $this->normalizePassport($e->passport_no));

                    foreach ($contracts as $c) {
                        $agr = $c->agreement;
                        $cli = $c->client;

                        $emp = null;
                        $contractPassportNorm = $this->normalizePassport($c->passport_no ?? null);
                        if ($contractPassportNorm) {
                            $emp = $employeesByPassport[$contractPassportNorm] ?? null;
                        }

                        $contractedAmount = $agr?->contracted_amount;
                        if (
                            $contractedAmount === null ||
                            $contractedAmount === '' ||
                            (is_numeric($contractedAmount) && (float) $contractedAmount == 0.0)
                        ) {
                            $contractedAmount = $agr?->total_amount;
                        }
                        $contractedAmount = $contractedAmount ?? 0;

                        $receivedAmount =
                            $c->received_amount
                            ?? $c->amount_received
                            ?? $agr?->received_amount
                            ?? $agr?->amount_received
                            ?? 0;

                        $balanceAmount =
                            $c->balance_amount
                            ?? $c->amount_balance
                            ?? ((float) $contractedAmount - (float) $receivedAmount);

                        $visaStatusLabel = $emp ? ($visaStatusMap[(int) ($emp->visa_status ?? 0)] ?? 'Unknown') : '';

                        fputcsv($out, [
                            $c->reference_no ?? '',
                            $this->salesName($c->salesPerson),
                            $statusMap[(int) ($c->status ?? 0)] ?? 'Unknown',
                            $this->installmentsText($c),
                            $this->formatDate($c->created_at ?? null),
                            $c->CN_Number ?? '—',
                            $agr?->candidate_name ?? ($c->candidate_name ?? '—'),
                            $agr?->nationality ?? ($c->nationality ?? '—'),
                            $cli?->CL_Number ?? '—',
                            $this->customerName($cli),
                            $this->money($contractedAmount),
                            $this->money($receivedAmount),
                            $this->money($balanceAmount),
                            $c->package ?? '',
                            $this->formatDate($c->contract_start_date ?? null),
                            $this->formatDate($c->contract_end_date ?? null),
                            $c->maid_delivered ?? '',
                            $this->formatDate($c->transferred_date ?? null),
                            $c->remarks ?? '',
                            $visaStatusLabel,
                            $emp?->passport_no ?? ($c->passport_no ?? ''),
                            $this->formatDate($emp?->passport_expiry_date),
                            $this->formatDate($emp?->date_of_joining),
                            $emp?->visa_designation ?? '',
                            $this->formatDate($emp?->date_of_birth),
                            $emp?->gender ?? '',
                            $emp?->salary_as_per_contract ?? '',
                            $emp?->basic ?? '',
                            $emp?->housing ?? '',
                            $emp?->transport ?? '',
                            $emp?->other_allowances ?? '',
                            $emp?->total_salary ?? '',
                            $emp?->payment_type ?? '',
                            $emp?->bank_name ?? '',
                            $emp?->iban ?? '',
                            $emp?->remarks ?? '',
                            $emp?->comments ?? '',
                        ]);
                    }
                });

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    protected function money($v): string
    {
        if ($v === null || $v === '') {
            return '0.00';
        }
        if (is_numeric($v)) {
            return number_format((float) $v, 2, '.', '');
        }
        return (string) $v;
    }

    protected function formatDate($v): string
    {
        if (empty($v)) {
            return '';
        }
        try {
            return Carbon::parse($v)->format($this->dateFormat);
        } catch (\Throwable $e) {
            return '';
        }
    }

    protected function normalizePassport(?string $v): ?string
    {
        if ($v === null) {
            return null;
        }
        $v = strtoupper(trim($v));
        $v = str_replace([' ', '-', '/', '.', "\t", "\n", "\r"], '', $v);
        return $v !== '' ? $v : null;
    }

    protected function customerName($client): string
    {
        $first = trim((string) ($client?->first_name ?? ''));
        $last = trim((string) ($client?->last_name ?? ''));
        $full = trim($first . ' ' . $last);
        return $full !== '' ? $full : '—';
    }

    protected function salesName($salesPerson): string
    {
        $first = trim((string) ($salesPerson?->first_name ?? ''));
        $last = trim((string) ($salesPerson?->last_name ?? ''));
        $full = trim($first . ' ' . $last);
        return $full !== '' ? $full : '—';
    }

    protected function installmentsText($contract): string
    {
        $total = (int) ($contract->number_of_installments ?? ($contract->installments_count ?? 0));
        $paid = (int) ($contract->paid_installments ?? 0);

        if ($total <= 0) {
            return 'No';
        }

        $nextDue = null;

        if (!empty($contract->nextPaymentDueAt)) {
            try {
                $nextDue = Carbon::parse($contract->nextPaymentDueAt);
            } catch (\Throwable $e) {
                $nextDue = null;
            }
        }

        if ($nextDue === null) {
            $nearest = null;

            foreach (($contract->installments ?? []) as $ins) {
                foreach (($ins->items ?? []) as $it) {
                    if (!empty($it->invoice_generated)) {
                        continue;
                    }
                    if (empty($it->payment_date)) {
                        continue;
                    }

                    try {
                        $d = Carbon::parse($it->payment_date);
                    } catch (\Throwable $e) {
                        continue;
                    }

                    if ($nearest === null || $d->lt($nearest)) {
                        $nearest = $d;
                    }
                }
            }

            $nextDue = $nearest;
        }

        $label = $paid . '/' . $total;
        if ($nextDue) {
            $label .= ' (' . $nextDue->format($this->dateFormat) . ')';
        }

        return $label;
    }

    protected function normalizePackage(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $v = strtoupper(trim($value));

        $map = [
            'PKG-2' => 'PKG-2',
            'PKG-3' => 'PKG-3',
            'PKG-4' => 'PKG-4',
            'PKG 2' => 'PKG-2',
            'PKG 3' => 'PKG-3',
            'PKG 4' => 'PKG-4',
            'PACKAGE 2' => 'PKG-2',
            'PACKAGE 3' => 'PKG-3',
            'PACKAGE 4' => 'PKG-4',
            '2' => 'PKG-2',
            '3' => 'PKG-3',
            '4' => 'PKG-4',
        ];

        return $map[$v] ?? $v;
    }
}
