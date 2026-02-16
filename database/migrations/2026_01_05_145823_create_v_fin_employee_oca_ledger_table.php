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
        Schema::create('v_fin_employee_oca_ledger', function (Blueprint $table) {
            $table->decimal('balance_change', 19)->nullable();
            $table->decimal('credit', 18)->nullable();
            $table->decimal('debit', 18)->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('employee_name', 200)->nullable();
            $table->date('journal_date')->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->string('oca_account_code', 20)->nullable();
            $table->string('package_code', 20)->nullable();
            $table->string('reference_no', 80)->nullable();
            $table->string('source_type', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_employee_oca_ledger');
    }
};
