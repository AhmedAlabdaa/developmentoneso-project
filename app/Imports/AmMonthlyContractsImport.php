<?php

namespace App\Imports;

use App\Models\CRM;
use App\Models\AmContractMovment;
use App\Models\Employee;
use App\Services\AmMonthlyContractService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Enum\EnumMaidStatus;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class AmMonthlyContractsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    protected int $contractsCreated = 0;
    protected int $contractsSkipped = 0;
    protected array $errors = [];
    protected array $seenPairs = [];

    public function __construct(protected AmMonthlyContractService $service)
    {
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            $rowNumber = $i + 2;

            try {
                $data = $this->transformRow($row);

                if ($this->shouldSkipDuplicatePair($data)) {
                    $this->contractsSkipped++;
                    continue;
                }

                $this->service->createContract($data);
                $this->contractsCreated++;
            } catch (\Throwable $e) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'error' => $e->getMessage(),
                ];
            }
        }
    }

    protected function transformRow($row): array
    {
        $customerRaw = trim((string) ($row['customer'] ?? ''));
        $maidRaw = trim((string) ($row['maid'] ?? ''));
        $startRaw = trim((string) ($row['start'] ?? ''));
        $endRaw = trim((string) ($row['end'] ?? ''));
        $amountRaw = $row['amount'] ?? null;
        $firstInstallmentDateRaw = trim((string) ($row['date_of_installment'] ?? ''));

        if ($customerRaw === '' || $maidRaw === '' || $startRaw === '' || $amountRaw === null) {
            throw new \Exception('Required columns: customer, maid, start, amount.');
        }

        $customer = $this->resolveCustomer($customerRaw);
        if (!$customer) {
            throw new \Exception("Customer not found: {$customerRaw}");
        }

        $maid = $this->resolveMaid($maidRaw);
        if (!$maid) {
            throw new \Exception("Maid not found: {$maidRaw}");
        }

        $startDate = $this->parseExcelDate($startRaw)->format('Y-m-d');
        $endedDate = $endRaw !== '' ? $this->parseExcelDate($endRaw)->endOfMonth()->format('Y-m-d') : null;
        $amount = (float) $amountRaw;

        if ($amount < 0) {
            throw new \Exception('Amount must be >= 0');
        }

        $installments = [];
        $hasInstallmentDate = $firstInstallmentDateRaw !== '';

        if ($hasInstallmentDate) {
            $firstInstallmentDate = $this->parseExcelDate($firstInstallmentDateRaw);

            if ($endedDate) {
                $end = Carbon::parse($endedDate);
                $firstDate = $firstInstallmentDate->copy();

                // Number of installments is based on (end month - first installment month).
                $monthsCount = (($end->year * 12 + $end->month) - ($firstDate->year * 12 + $firstDate->month)) + 1;

                if ($monthsCount < 0) {
                    throw new \Exception('End date must be after or equal to date_of_installment.');
                }

                for ($m = 0; $m < $monthsCount; $m++) {
                    $installments[] = [
                        'date' => $firstInstallmentDate->copy()->addMonths($m)->format('Y-m-d'),
                        'amount' => $amount,
                        'note' => 'Imported from Excel',
                    ];
                }
            } else {
                $installments[] = [
                    'date' => $firstInstallmentDate->format('Y-m-d'),
                    'amount' => $amount,
                    'note' => 'Imported from Excel',
                ];
            }
        }

        return [
            'start_date' => $startDate,
            'ended_date' => $endedDate,
            'customer_id' => $customer->id,
            'maid_id' => $maid->id,
            'installment' => $installments,
        ];
    }

    protected function resolveCustomer(string $raw): ?CRM
    {
        $rawNormalized = mb_strtolower(trim($raw));
        return CRM::query()
            ->whereRaw('LOWER(TRIM(emirates_id)) = ?', [$rawNormalized])
            ->first();
    }

    protected function resolveMaid(string $raw): ?Employee
    {
        if (is_numeric($raw)) {
            $employee = Employee::find((int) $raw);
            if ($employee) {
                return $employee;
            }
        }

        return Employee::query()
            ->where('emirates_id', $raw)
            ->orWhere('passport_no', $raw)
            ->orWhere('name', 'like', "%{$raw}%")
            ->first();
    }

    public function getContractsCreated(): int
    {
        return $this->contractsCreated;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getContractsSkipped(): int
    {
        return $this->contractsSkipped;
    }

    protected function shouldSkipDuplicatePair(array $data): bool
    {
        $pairKey = $data['customer_id'] . ':' . $data['maid_id'];
        if (isset($this->seenPairs[$pairKey])) {
            return true;
        }

        $existsInDb = AmContractMovment::query()
            ->where('employee_id', $data['maid_id'])
            ->whereHas('primaryContract', function ($query) use ($data) {
                $query->where('crm_id', $data['customer_id']);
            })
            ->exists();

        if ($existsInDb) {
            return true;
        }

        $this->seenPairs[$pairKey] = true;
        return false;
    }

    protected function parseExcelDate(mixed $value): Carbon
    {
        if ($value instanceof \DateTimeInterface) {
            return Carbon::instance($value);
        }

        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject((float) $value));
        }

        return Carbon::parse((string) $value);
    }
}
