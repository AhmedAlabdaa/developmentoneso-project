<?php

namespace App\Services;

use App\Enum\Spacial;
use App\Models\AmPrimaryContract;
use App\Models\AmContractMovment;
use App\Models\AmInstallment;
use App\Models\AmMonthlyContractInv;
use App\Models\Employee;
use App\Models\LedgerOfAccount;
use App\Services\JournalHeaderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use App\Enum\EnumMaidStatus;

class AmMonthlyContractService
{
    protected JournalHeaderService $journalService;

    public function __construct(JournalHeaderService $journalService)
    {
        $this->journalService = $journalService;
    }

    /**
     * Create a new AmMonthlyContract with movement and installments.
     *
     * @param array $data
     * @return AmPrimaryContract
     * @throws Exception
     */
    public function createContract(array $data)
    {
        DB::beginTransaction();

        try {
            // 1. Create AmPrimaryContract
            $contract = AmPrimaryContract::create([
                'date' => $data['start_date'],
                'crm_id' => $data['customer_id'],
                'end_date' => $data['ended_date'] ?? null,
                'status' => 1, 
                'type' => 2,
            
            ]);

            // 2. Create AmContractMovment
            $movement = AmContractMovment::create([
                'date' => $data['start_date'],
                'am_contract_id' => $contract->id,
                'employee_id' => $data['maid_id'],
                'status' => 1, 
               
            ]);

            // 3. Update Employee inside_status to Hired
            $employee = Employee::findOrFail($data['maid_id']);
            $employee->update(['inside_status' => EnumMaidStatus::HIRED->value]);

            // 4. Create AmInstallments
            if (isset($data['installment']) && is_array($data['installment'])) {
                $installmentsData = array_map(function ($installmentData) {
                    return [
                        'date' => $installmentData['date'],
                        'note' => $installmentData['note'] ?? null,
                        'amount' => $installmentData['amount'] ?? 0,
                        'status' => 0, // Pending
                        // 'created_by' => auth()->id(),
                    ];
                }, $data['installment']);

                $movement->installments()->createMany($installmentsData);
            }

            // 5. Prorate Amount & Journal Entry (optional)
            if (!empty($data['prorate_amount'])) {
                $crm = $contract->crm;
                $days = $data['prorate_days'];

                // Ledger Resolution
                $customerLedgerId = $crm->ledger_id;
                $vatLedgerId = $this->resolveLedger('VAT Output', 'name', '%VAT OUTPUT%');
                $maidSalaryLedgerId = $this->resolveLedger('Maid Salary', 'spacial', Spacial::maidSalary);
                $p3ProfitLedgerId = $this->resolveLedger('P3 Profit', 'spacial', Spacial::p3Profit);

                $monthlySalary = $employee->salary ?? 0;
                $salaryCost = round(($monthlySalary / 30) * $days, 2);
                // prorate_amount is the full monthly rate, then prorated by days
                $monthlyRate = $data['prorate_amount'];
                $totalAmount = round(($monthlyRate / 30) * $days, 2);

                // VAT is only on (total prorate - salary), inclusive 5%
                $taxableAmount = round($totalAmount - $salaryCost, 2);
                if ($taxableAmount < 0) {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], []),
                        response()->json([
                            'message' => 'Prorate amount is less than maid salary.',
                            'errors' => [
                                'prorate_amount' => [
                                    "Prorate amount (" . round($totalAmount, 2) . ") is less than maid salary cost (" . round($salaryCost, 2) . ")."
                                ]
                            ]
                        ], 422)
                    );
                }

                $vatAmount = round(($taxableAmount / 1.05) * 0.05, 2);
                $profitAmount = round($taxableAmount - $vatAmount, 2);

                // Create Prorate Invoice Record
                $invoice = AmMonthlyContractInv::create([
                    'date' => $data['start_date'],
                    'am_monthly_contract_id' => $movement->id,
                    'crm_id' => $crm->id,
                    'note' => "Prorate ({$days} days)",
                    'amount' => $totalAmount,
                    'paid_amount' => 0,
                ]);

                // Create Journal Entry linked to the invoice
                $this->journalService->createJournal([
                    'posting_date' => $data['start_date'],
                    'note' => "Prorate for Contract #{$contract->id} ({$days} days)",
                    'source_type' => AmMonthlyContractInv::class,
                    'source_id' => $invoice->id,
                    'status' => \App\Enum\JournalStatus::Draft,
                    'lines' => [
                        [
                            'ledger_id' => $customerLedgerId,
                            'debit' => $totalAmount,
                            'credit' => 0,
                            'note' => "Prorate - Customer Charge ({$days} days)",
                        ],
                        [
                            'ledger_id' => $vatLedgerId,
                            'debit' => 0,
                            'credit' => $vatAmount,
                            'note' => "VAT Output (5%)",
                        ],
                        [
                            'ledger_id' => $maidSalaryLedgerId,
                            'debit' => 0,
                            'credit' => $salaryCost,
                            'note' => "Maid Salary Cost ({$days} days)",
                        ],
                        [
                            'ledger_id' => $p3ProfitLedgerId,
                            'debit' => 0,
                            'credit' => $profitAmount,
                            'note' => "P3 Profit (prorate)",
                        ],
                    ],
                ]);
            }

            DB::commit();

            return $contract->load(['contractMovments.installments', 'contractMovments.employee']);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }



    /**
     * Update an existing contract.
     *
     * @param AmPrimaryContract $contract
     * @param array $data
     * @return AmPrimaryContract
     * @throws Exception
     */
    public function updateContract(AmPrimaryContract $contract, array $data)
    {
        DB::beginTransaction();

        try {
            // 1. Update AmPrimaryContract fields
            $updateData = [];
            if (isset($data['date'])) {
                $updateData['date'] = $data['date'];
            }
            if (isset($data['end_date'])) {
                $updateData['end_date'] = $data['end_date'];
            }
            if (isset($data['note'])) {
                $updateData['note'] = $data['note'] ?: null;
            }

            if (!empty($updateData)) {
                $contract->update($updateData);
            }

      

            DB::commit();

            return $contract->refresh()->load(['contractMovments.installments', 'contractMovments.employee']);

        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete a contract.
     *
     * @param AmPrimaryContract $contract
     * @return bool|null
     * @throws Exception
     */
    public function deleteContract(AmPrimaryContract $contract)
    {
        DB::beginTransaction();

        try {       
            $contract->delete();
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Resolve a ledger account by name (LIKE) or spacial enum.
     *
     * @param string $label Human-readable label for error messages
     * @param string $field 'name' or 'spacial'
     * @param mixed $value
     * @return int Ledger ID
     * @throws Exception
     */
    protected function resolveLedger(string $label, string $field, $value): int
    {
        if ($field === 'name') {
            $ledger = LedgerOfAccount::where('name', 'like', $value)->first()
                ?? LedgerOfAccount::where('name', 'VAT Output')->first();
        } else {
            $ledger = LedgerOfAccount::where($field, $value)->first();
        }

        if (!$ledger) {
            throw new Exception("{$label} Ledger not found");
        }

        return $ledger->id;
    }

    public function generateEmployeeReferenceNo(): string
    {
        $last = Employee::whereNotNull('reference_no')
            ->where('reference_no', 'like', 'EP3-%')
            ->orderByRaw("CAST(SUBSTRING(reference_no, 5) AS UNSIGNED) DESC")
            ->value('reference_no');

        if (!$last) {
            return 'EP3-' . str_pad('1', 4, '0', STR_PAD_LEFT);
        }

        if (!preg_match('/^EP3-(\d+)$/', $last, $matches)) {
            return 'EP3-' . str_pad('1', 4, '0', STR_PAD_LEFT);
        }

        $number = (int) $matches[1];

        return 'EP3-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }

    public function createEmployee(array $data): Employee
    {
        $referenceNo = $this->generateEmployeeReferenceNo();

        return Employee::create([
            'reference_no' => $referenceNo,
            'CN_Number' => null,
            'package' => 'PKG-3',
            'name' => $data['name'],
            'slug' => Str::slug($data['name'] . '-' . $referenceNo),
            'nationality' => $data['nationality'],
            'passport_expiry_date' => $data['passport_expiry_date'],
            'passport_no' => $data['passport_no'] ?? null,
            'emirates_id' => $data['emirates_id'] ?? null,
            'salary' => $data['salary'] ?? 1200,
            'payment_type' => $data['payment_type'] ?? null,
            'inside_country_or_outside' => 1,
            'inside_status' => EnumMaidStatus::PENDING->value,
            'current_status' => 1,
            'status' => 1,
        ]);
    }
}
