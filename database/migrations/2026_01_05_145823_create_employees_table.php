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
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no')->unique();
            $table->string('CN_Number')->nullable();
            $table->string('CL_Number')->nullable();
            $table->string('package');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_keywords_ar', 1000)->nullable();
            $table->string('meta_description_ar', 1000)->nullable();
            $table->string('nationality');
            $table->string('emirates_id')->nullable();
            $table->string('passport_no', 50)->nullable();
            $table->date('passport_expiry_date');
            $table->date('date_of_joining')->nullable();
            $table->string('visa_designation')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('arrived_date')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->date('employment_contract_start_date')->nullable();
            $table->date('employment_contract_end_date')->nullable();
            $table->string('contract_type')->nullable();
            $table->string('file_entry_permit_no')->nullable();
            $table->date('file_entry_permit_issued_date')->nullable();
            $table->date('file_entry_permit_expired_date')->nullable();
            $table->string('uid_no')->nullable();
            $table->string('foreign_partner')->nullable();
            $table->string('personal_no')->nullable();
            $table->string('labor_card_no')->nullable();
            $table->date('labor_card_issued_date')->nullable();
            $table->date('labor_card_expiry_date')->nullable();
            $table->string('iloe_number')->nullable();
            $table->date('iloe_issued_date')->nullable();
            $table->date('iloe_expired_date')->nullable();
            $table->string('insurance_policy_number')->nullable();
            $table->date('insurance_policy_issued_date')->nullable();
            $table->date('insurance_policy_expired_date')->nullable();
            $table->date('residence_visa_start_date')->nullable();
            $table->date('residence_visa_expiry_date')->nullable();
            $table->date('eid_issued_date')->nullable();
            $table->date('eid_expiry_date')->nullable();
            $table->decimal('salary_as_per_contract', 10)->nullable();
            $table->decimal('basic', 10)->nullable();
            $table->decimal('housing', 10)->nullable();
            $table->decimal('transport', 10)->nullable();
            $table->decimal('other_allowances', 10)->nullable();
            $table->decimal('total_salary', 10)->nullable();
            $table->string('payment_type', 50)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban', 23)->nullable();
            $table->text('comments')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('current_status')->default(1)->comment('This status is realated to outside journey status
');
            $table->integer('status')->default(1)->comment('This is related incident status.

1 = Active
2 = Absconded
3 - Cancelled
');
            $table->integer('inside_country_or_outside')->default(1)->comment('1 = outside , 2 = inside');
            $table->integer('visa_status')->nullable();
            $table->integer('inside_status')->default(0)->comment('0 = All
1 = Office
2 = Contracted
3 = Incidented');
            $table->string('incident_type')->nullable();
            $table->date('incident_date')->nullable();
            $table->timestamps();
            $table->decimal('montly_salary', 10)->nullable();
            $table->string('contract_period', 100)->nullable();
            $table->string('religion', 100)->nullable();
            $table->string('place_of_birth', 150)->nullable();
            $table->string('living_town', 150)->nullable();
            $table->string('maritial_status', 50)->nullable();
            $table->unsignedSmallInteger('no_of_childrens')->nullable();
            $table->decimal('weight', 5)->nullable();
            $table->decimal('height', 5)->nullable();
            $table->string('education', 150)->nullable();
            $table->string('contract_no', 100)->nullable();
            $table->text('languages')->nullable();
            $table->text('working_experience')->nullable();
            $table->text('previous_employements')->nullable();
            $table->string('family_contract_no', 100)->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->string('place_of_issue', 150)->nullable();
            $table->date('expiry_date')->nullable();
            $table->decimal('salary', 10)->default(1200);
            $table->unsignedTinyInteger('marital_status')->nullable();
            $table->unsignedInteger('children_count')->default(0);
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->string('sponsor_name')->nullable();
            $table->string('visa_type')->nullable();
            $table->string('contract_duration')->nullable();
            $table->string('contract_end_date')->nullable();
            $table->string('sales_name')->nullable();
            $table->integer('sale_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
