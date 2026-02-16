<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('typing_tran_gov_invs', function (Blueprint $table) {
            $table->unsignedBigInteger('ledger_id')->nullable()->after('maid_id');
            $table->foreign('ledger_id')->references('id')->on('ledger_of_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('typing_tran_gov_invs', function (Blueprint $table) {
            $table->dropForeign(['ledger_id']);
            $table->dropColumn('ledger_id');
        });
    }
};
