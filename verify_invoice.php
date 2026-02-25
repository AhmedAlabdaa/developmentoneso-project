<?php

use Illuminate\Support\Facades\DB;
use App\Models\AmPrimaryContract;
use App\Models\AmContractMovment;
use App\Models\AmInstallment;
use App\Models\CRM;
use App\Models\Employee;
use App\Models\LedgerOfAccount;
use App\Models\User;
use App\Enum\Spacial;
use App\Http\Controllers\AmInvoiceMonthlyICntl;
use App\Services\JournalHeaderService;
use Illuminate\Http\Request;

try {
    DB::beginTransaction();

    echo "--- Starting Verification ---\n";

    // 1. Setup Models
    $user = User::first() ?? User::factory()->create();

    // Ledgers - Find or Create Mock
    $vatLedger = LedgerOfAccount::firstOrCreate(
        ['name' => 'VAT OUTPUT'], 
        ['code' => '2100', 'type' => 2, 'class' => \App\Enum\LedgerClass::LIABILITY, 'sub_class' => \App\Enum\SubClass::CURRENT_LIABILITY]
    );

    $maidSalaryLedger = LedgerOfAccount::firstOrCreate(
        ['spacial' => Spacial::maidSalary],
        ['name' => 'Maid Salary Expense', 'type' => 1, 'class' => \App\Enum\LedgerClass::EXPENSE, 'sub_class' => \App\Enum\SubClass::EXPENSE]
    );

    $p3ProfitLedger = LedgerOfAccount::firstOrCreate(
        ['spacial' => Spacial::p3Profit],
        ['name' => 'P3 Profit Income', 'type' => 1, 'class' => \App\Enum\LedgerClass::INCOME, 'sub_class' => \App\Enum\SubClass::INCOME]
    );

    $crm = CRM::first();
    if (!$crm) {
        $customerLedger = LedgerOfAccount::create(['name' => 'Test Customer', 'type' => 1, 'class' => \App\Enum\LedgerClass::ASSET, 'sub_class' => \App\Enum\SubClass::CURRENT_ASSET]);
        $crm = CRM::create(['first_name' => 'Test', 'last_name' => 'Customer', 'ledger_id' => $customerLedger->id]);
    }

    $employee = Employee::first();
    // Ensure mock employee has salary
    if (!$employee) {
        echo "No Employee found, skipping detailed creation for now.\n";
    }

    // Create Contract Chain
    $contract = new AmPrimaryContract();
    $contract->crm_id = $crm->id;
    $contract->date = now();
    $contract->save();

    $movement = new AmContractMovment();
    $movement->am_contract_id = $contract->id;
    $movement->employee_id = $employee ? $employee->id : null; 
    $movement->save();

    $installment = new AmInstallment();
    $installment->am_movment_id = $movement->id;
    $installment->amount = 3150; // 3000 + 150 VAT (5%)
    $installment->date = now();
    $installment->status = 0;
    $installment->save();

    echo "Created Mock Installment ID: " . $installment->id . "\n";


    // 2. Invoke Controller
    $service = new JournalHeaderService();
    $controller = new AmInvoiceMonthlyICntl($service);
    
    // Simulate Request
    $request = Request::create('/api/invoice', 'POST', [
        'installment_id' => $installment->id,
        'calculation_type' => 'monthly'
    ]);

    $response = $controller->store($request);
    
    echo "Response Code: " . $response->getStatusCode() . "\n";
    echo "Content: " . $response->getContent() . "\n";


    // 3. Verify Database State
    $invoice = \App\Models\AmMonthlyContractInv::where('am_installment_id', $installment->id)->first();
    
    if ($invoice) {
        echo "SUCCESS: Invoice created with Serial: " . $invoice->serial_no . "\n";
        
        $journal = $invoice->journal;
        if ($journal) {
            echo "SUCCESS: Journal Header created ID: " . $journal->id . "\n";
            foreach ($journal->lines as $line) {
                echo " - Line: " . $line->note . " | Dr: " . $line->debit . " | Cr: " . $line->credit . "\n";
            }
        } else {
            echo "FAILURE: Journal Header NOT created.\n";
        }

        $installment->refresh();
        echo "Installment Status: " . $installment->status . " (Expected 1)\n";

    } else {
        echo "FAILURE: Invoice record NOT created.\n";
    }

    DB::rollBack();
    echo "--- Verification Complete (Rolled Back) ---\n";

} catch (\Exception $e) {
    DB::rollBack();
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
