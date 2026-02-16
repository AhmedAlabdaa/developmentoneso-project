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
        Schema::table('crm', function (Blueprint $table) {
            $table->foreignId('ledger_id')
                ->nullable()
                ->after('id')
                ->constrained('ledger_of_accounts')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crm', function (Blueprint $table) {
            $table->dropForeign(['ledger_id']);
            $table->dropColumn('ledger_id');
        });
    }
};
