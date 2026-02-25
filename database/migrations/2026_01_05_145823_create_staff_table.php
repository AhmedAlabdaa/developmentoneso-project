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
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status', ['AVAILABLE', 'HOLD', 'SELECTED', 'WC-DATE', 'VISA DATE']);
            $table->string('reference_no')->unique();
            $table->string('name_of_staff');
            $table->string('slug')->unique();
            $table->string('nationality');
            $table->string('passport_no')->unique();
            $table->date('date_of_joining')->nullable();
            $table->string('actual_designation')->nullable();
            $table->string('visa_designation')->nullable();
            $table->date('passport_expiry_date');
            $table->enum('gender', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status', ['married', 'unmarried', 'other'])->nullable();
            $table->date('employment_contract_start_date')->nullable();
            $table->date('employment_contract_end_date')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('file_entry_permit_no')->nullable();
            $table->string('uid_no')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('temp_work_permit_no')->nullable();
            $table->date('temp_work_permit_expiry_date')->nullable();
            $table->string('personal_no')->nullable();
            $table->string('labor_card_no')->nullable()->unique();
            $table->date('labor_card_expiry_date')->nullable();
            $table->date('residence_visa_start_date')->nullable();
            $table->date('residence_visa_expiry_date')->nullable();
            $table->string('emirates_id_number')->nullable()->unique();
            $table->date('eid_expiry_date')->nullable();
            $table->decimal('salary_as_per_contract', 10)->nullable();
            $table->decimal('basic', 10)->nullable();
            $table->decimal('housing', 10)->nullable();
            $table->decimal('transport', 10)->nullable();
            $table->decimal('other_allowances', 10)->nullable();
            $table->decimal('total_salary', 10)->nullable();
            $table->boolean('pc')->nullable()->default(false);
            $table->boolean('laptop')->nullable()->default(false);
            $table->boolean('mobile')->nullable()->default(false);
            $table->boolean('company_sim')->nullable()->default(false);
            $table->boolean('printer')->nullable()->default(false);
            $table->enum('wps_cash', ['WPS', 'CASH'])->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban', 23)->nullable()->unique();
            $table->text('comments')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
