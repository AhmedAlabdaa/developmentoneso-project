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
        Schema::create('coa_accounts', function (Blueprint $table) {
            $table->bigIncrements('account_id');
            $table->string('account_code', 20)->unique('uq_coa_account_code');
            $table->string('account_name', 200);
            $table->string('parent_account_code', 20)->nullable()->index('idx_coa_parent_code');
            $table->enum('account_type', ['ASSET', 'LIABILITY', 'EQUITY', 'INCOME', 'EXPENSE'])->index('idx_coa_type');
            $table->enum('normal_balance', ['D', 'C']);
            $table->boolean('is_posting')->default(true);
            $table->boolean('is_control')->default(false);
            $table->enum('currency_code', ['AED'])->default('AED');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coa_accounts');
    }
};
