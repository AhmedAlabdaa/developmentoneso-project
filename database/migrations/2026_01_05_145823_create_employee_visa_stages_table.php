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
        Schema::create('employee_visa_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('step_id');
            $table->date('hr_issue_date');
            $table->string('hr_file_number', 191)->nullable();
            $table->date('hr_expiry_date');
            $table->string('hr_attach_file')->nullable();
            $table->string('ica_proof')->nullable();
            $table->decimal('fin_paid_amount', 12)->nullable();
            $table->string('fin_zoho_proof')->nullable();
            $table->string('fin_gov_invoice_proof')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_visa_stages');
    }
};
