<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     */
    public function up(): void
    {
        $crmRecords = DB::table('crm')
            ->whereNull('ledger_id')
            ->get();

        foreach ($crmRecords as $crm) {
 
            $ledgerId = DB::table('ledger_of_accounts')->insertGetId([
                'name'       => $crm->first_name,
                'class'      => 1,
                'sub_class'  => 1,
                'group'      => 'account receivable',
                'spacial'    => 3,
                'type'       => 'dr',
                'note'       => $crm->mobile,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

   
            DB::table('crm')
                ->where('id', $crm->id)
                ->update(['ledger_id' => $ledgerId]);
        }
    }

    /**
     * Reverse the migrations.
     * 
     * This will delete ledger entries that were created by this migration
     * and set the ledger_id back to null on CRM records.
     */
    public function down(): void
    {
        // Find CRM records that have ledgers matching our criteria
        // and set their ledger_id back to null
        $ledgerIds = DB::table('ledger_of_accounts')
            ->where('class', 1)
            ->where('sub_class', 1)
            ->where('group', 'account receivable')
            ->where('spacial', 3)
            ->where('type', 'dr')
            ->pluck('id');

        // Set ledger_id to null for affected CRM records
        DB::table('crm')
            ->whereIn('ledger_id', $ledgerIds)
            ->update(['ledger_id' => null]);

        // Note: We don't delete the ledger entries as they might have
        // been used in journal transactions. If you're sure they're unused,
        // uncomment the following:
        // DB::table('ledger_of_accounts')->whereIn('id', $ledgerIds)->delete();
    }
};
