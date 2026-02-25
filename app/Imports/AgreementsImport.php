<?php

namespace App\Imports;

use App\Models\Agreement;
use App\Models\Contract;
use App\Models\CRM;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\InstallmentItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgreementsImport implements ToCollection, WithHeadingRow
{
    use Importable;

    protected int $agreementsCreated   = 0;
    protected int $installmentsCreated = 0;
    protected int $contractsCreated    = 0;
    protected array $errors            = [];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $i => $row) {
            try {
                $data = $this->transformRow($row);
                DB::transaction(fn() => $this->processRow($data));
            } catch (\Throwable $e) {
                $this->errors[] = ['row' => $i + 2, 'error' => $e->getMessage()];
            }
        }
    }

    protected function transformRow($row): array
    {
        $period  = (int)   ($row['contract_period']   ?? 0);
        $amount  = (float) ($row['contract_amount']   ?? 0);
        $monthly = (float) ($row['monthly_payment']   ?? 0);
        if ($period <= 0)         throw new \Exception('invalid period');
        if ($amount  <= 0)         throw new \Exception('invalid amount');
        if (! is_numeric($monthly)) throw new \Exception('invalid monthly');
        return [
            'name'      => trim($row['name']                ?? ''),
            'eid'       => trim($row['sponsor_id']          ?? ''),
            'package'   => trim($row['package_type']        ?? ''),
            'start'     => trim($row['contract_start_date'] ?? ''),
            'end'       => trim($row['contract_end_date']   ?? ''),
            'period'    => $period,
            'amount'    => $amount,
            'monthly'   => $monthly,
            'salary'    => trim($row['salary']              ?? ''),
        ];
    }

    protected function processRow(array $d): void
    {
        $userId = Auth::id();

        $client = CRM::firstWhere('emirates_id', $d['eid']);
        if (!$client->CL_Number) {
            $client->CL_Number = 'CL-' . str_pad($client->id, 4, '0');
            $client->save();
        }

        $model     = $d['package'] === 'PKG-1' ? Package::class : Employee::class;
        $candidate = $model::firstWhere('name', $d['name']);
        $refCol    = $d['package'] === 'PKG-1' ? 'hr_ref_no' : 'reference_no';
        if (!$candidate->$refCol) {
            $candidate->$refCol = 'CN-' . str_pad($candidate->id, 4, '0');
            $candidate->save();
        }
        $candRef = $candidate->$refCol;

        Agreement::where('candidate_id', $candidate->id)
            ->where('client_id', $client->id)
            ->get()
            ->each(fn($agr) => $this->deleteExisting($agr));

        $terms = $d['monthly'] > 0 ? 'partial' : 'full';
        $total = $terms === 'partial'
            ? $d['amount'] + $d['period'] * $d['monthly']
            : $d['amount'];
        $type = $terms === 'full' ? 'BOA' : 'BIA';

        if ($type === 'BOA' && $d['package'] === 'PKG-1') {
            $prefix = 'BOA-P1-';
        } elseif ($type === 'BOA') {
            $prefix = 'BOA-E-';
        } elseif ($type === 'BIA' && $d['package'] === 'PKG-1') {
            $prefix = 'BIA-P1-';
        } else {
            $prefix = 'BIA-E-';
        }

        $agrRef = $this->nextNumber(Agreement::class, 'reference_no', $prefix, 5);

        Agreement::create([
            'reference_no'           => $agrRef,
            'agreement_type'         => $type,
            'candidate_id'           => $candidate->id,
            'candidate_name'         => $d['name'],
            'reference_of_candidate' => $candRef,
            'ref_no_in_of_previous'  => $candRef,
            'client_id'              => $client->id,
            'CL_Number'              => $client->CL_Number,
            'CN_Number'              => $candRef,
            'package'                => $d['package'],
            'salary'                 => $d['salary'],
            'monthly_payment'        => (string)$d['monthly'],
            'visa_type'              => 'D-SPO',
            'foreign_partner'        => $candidate->foreign_partner ?? $client->foreign_partner ?? '',
            'nationality'            => $candidate->nationality,
            'passport_no'            => $candidate->passport_no,
            'passport_expiry_date'   => $candidate->passport_expiry_date,
            'date_of_birth'          => $candidate->date_of_birth,
            'payment_method'         => 'cash',
            'total_amount'           => $total,
            'received_amount'        => $total,
            'remaining_amount'       => 0,
            'vat_amount'             => 0,
            'net_amount'             => $total,
            'contract_duration'      => "{$d['period']} months",
            'number_of_days'         => $d['period'],
            'trial_start_date'       => Carbon::parse($d['start'])->toDateString(),
            'trial_end_date'         => Carbon::parse($d['end'])->toDateString(),
            'payment_terms'          => $terms,
            'status'                 => 5,
            'created_by'             => $userId,
        ]);

        $this->agreementsCreated++;

        $invoiceNumber = null;
        if ($client->id !== 1) {
            $invPref = $d['package'] === 'PKG-1' ? 'RVI-P1-' : 'INV-E-';
            $invoiceNumber = $this->nextNumber(Invoice::class, 'invoice_number', $invPref, 5);

            $inv = Invoice::create([
                'invoice_number'         => $invoiceNumber,
                'agreement_reference_no' => $agrRef,
                'customer_id'            => $client->id,
                'reference_no'           => $candRef,
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'invoice_type'           => $d['package'] === 'PKG-1' ? 'Proforma' : 'Tax',
                'payment_method'         => 'cash',
                'received_amount'        => $total,
                'invoice_date'           => now('Asia/Dubai'),
                'due_date'               => now('Asia/Dubai'),
                'total_amount'           => $total,
                'balance_due'            => 0,
                'status'                 => 'Paid',
                'created_by'             => $userId,
            ]);

            InvoiceItem::create([
                'invoice_id'   => $inv->invoice_id,
                'product_name' => 'Agreement: ' . $agrRef,
                'quantity'     => 1,
                'unit_price'   => $total,
                'total_price'  => $total,
            ]);
        }

        if ($terms === 'partial') {
            $instRef = $this->nextNumber(Installment::class, 'reference_no', 'INS-', 5);

            $inst = Installment::create([
                'reference_no'           => $instRef,
                'agreement_no'           => $agrRef,
                'invoice_number'         => $invoiceNumber,
                'CL_Number'              => $client->CL_Number,
                'CN_Number'              => $candRef,
                'customer_name'          => $client->first_name,
                'employee_name'          => $d['name'],
                'passport_no'            => $candidate->passport_no,
                'contract_duration'      => "{$d['period']} months",
                'contract_start_date'    => Carbon::parse($d['start'])->toDateString(),
                'contract_end_date'      => Carbon::parse($d['end'])->toDateString(),
                'package'                => $d['package'],
                'contract_amount'        => $total,
                'number_of_installments' => $d['period'],
                'paid_installments'      => 0,
                'created_by'             => $userId,
            ]);

            for ($j = 1; $j <= $d['period']; $j++) {
                InstallmentItem::create([
                    'installment_id'    => $inst->id,
                    'particular'        => "Installment #{$j}",
                    'amount'            => $d['monthly'],
                    'payment_date'      => Carbon::parse($d['start'])->addMonths($j - 1)->toDateString(),
                    'invoice_generated' => false,
                    'status'            => 'Pending',
                ]);
            }

            $this->installmentsCreated++;
        }

        $ctRef = $this->nextNumber(Contract::class, 'reference_no', 'CT-', 5);

        Contract::create([
            'reference_no'           => $ctRef,
            'agreement_type'         => $type,
            'agreement_reference_no' => $agrRef,
            'candidate_id'           => $candidate->id,
            'reference_of_candidate' => $candRef,
            'CL_Number'              => $client->CL_Number,
            'CN_Number'              => $candRef,
            'package'                => $d['package'],
            'foreign_partner'        => $candidate->foreign_partner ?? $client->foreign_partner ?? '',
            'contract_signed_copy'   => Str::uuid(),
            'client_id'              => $client->id,
            'contract_start_date'    => Carbon::parse($d['start'])->toDateString(),
            'contract_end_date'      => Carbon::parse($d['end'])->toDateString(),
            'transferred_date'       => Carbon::parse($d['end'])->toDateString(),
            'maid_delivered'         => 'No',
            'created_by'             => $userId,
        ]);

        $this->contractsCreated++;
    }

    protected function nextNumber(string $model, string $column, string $prefix, int $pad): string
    {
        $max = $model::where($column, 'like', "$prefix%")
            ->lockForUpdate()
            ->select(DB::raw("MAX(CAST(SUBSTRING_INDEX($column,'-',-1) AS UNSIGNED)) as max"))
            ->first()->max ?? 0;

        return $prefix . str_pad($max + 1, $pad, '0', STR_PAD_LEFT);
    }

    protected function deleteExisting(Agreement $agr): void
    {
        Installment::where('agreement_no', $agr->reference_no)
            ->get()
            ->each(fn($i) => InstallmentItem::where('installment_id', $i->id)->delete() && $i->delete());
        Invoice::where('agreement_reference_no', $agr->reference_no)
            ->get()
            ->each(fn($inv) => InvoiceItem::where('invoice_id', $inv->invoice_id)->delete() && $inv->delete());
        Contract::where('agreement_reference_no', $agr->reference_no)->delete();
        $agr->delete();
    }

    public function getAgreementsCreated(): int { return $this->agreementsCreated; }
    public function getInstallmentsCreated(): int { return $this->installmentsCreated; }
    public function getContractsCreated(): int { return $this->contractsCreated; }
    public function getErrors(): array { return $this->errors; }
}
