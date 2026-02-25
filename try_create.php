<?php
use App\Models\AmMonthlyContractInv;
use Illuminate\Support\Facades\DB;

try {
    echo "Testing AmMonthlyContractInv creation...\n";
    
    // Minimal data - using dummy IDs if foreign keys allow (or 0 if not constrained strongly in model, but DB enforces FK)
    // Actually we need valid IDs due to DB constraints. 
    // Let's rely on finding existing data or creating minimal parents.
    
    $crmId = DB::table('crm')->value('id');
    if (!$crmId) { echo "No CRM found. Cannot test.\n"; exit; }
    
    $contractMovmentId = DB::table('am_contract_movments')->value('id');
    if (!$contractMovmentId) { echo "No Movment found. Cannot test.\n"; exit; }

    $installmentId = DB::table('am_installments')->value('id');
    if (!$installmentId) { echo "No Installment found. Cannot test.\n"; exit; }

    $inv = AmMonthlyContractInv::create([
        'date' => now(),
        'am_monthly_contract_id' => $contractMovmentId,
        'crm_id' => $crmId,
        'am_installment_id' => $installmentId,
        'note' => 'Test',
        'amount' => 100,
        'paid_amount' => 0
    ]);
    
    echo "Created Invoice with Serial: " . $inv->serial_no . "\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
