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
        Schema::create('v_fin_customer_ledger', function (Blueprint $table) {
            $table->string('ar_account_code', 20)->nullable();
            $table->decimal('balance_change', 19)->nullable();
            $table->string('cl_number', 60)->nullable();
            $table->decimal('credit', 18)->nullable();
            $table->unsignedBigInteger('crm_customer_id')->nullable();
            $table->string('customer_name', 200)->nullable();
            $table->decimal('debit', 18)->nullable();
            $table->date('journal_date')->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->string('reference_no', 80)->nullable();
            $table->string('source_type', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_customer_ledger');
    }
};
