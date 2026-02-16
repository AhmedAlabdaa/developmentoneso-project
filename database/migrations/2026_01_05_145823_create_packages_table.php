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
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id')->nullable();
            $table->string('cn_number_series', 20)->unique('uq_packages_cn_number_series');
            $table->string('CN_Number', 20)->unique('uq_packages_cn_number');
            $table->string('hr_ref_no', 20)->unique('uq_packages_hr_ref_no');
            $table->string('sales_name');
            $table->string('foreign_partner')->nullable();
            $table->string('agreement_no')->nullable();
            $table->string('contract_no')->nullable();
            $table->string('candidate_name');
            $table->string('slug')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_keywords_ar', 1000)->nullable();
            $table->string('meta_description_ar', 1000)->nullable();
            $table->integer('current_status')->nullable();
            $table->integer('inside_status')->nullable()->default(0)->comment('0 = All
1 = Office
2 = Trial
3 = Confirm
4 = Change Status 
5 = Incident
6 = Contracted');
            $table->dateTime('change_status_date')->nullable();
            $table->date('cs_date')->nullable();
            $table->string('change_status_proof')->nullable();
            $table->string('penalty_payment_amount')->nullable();
            $table->string('penalty_payment_proof')->nullable();
            $table->string('penalty_paid_by')->nullable();
            $table->string('istiraha_proof')->nullable();
            $table->string('passport_no')->unique('uq_packages_passport_no');
            $table->date('passport_expiry_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('branch_in_uae')->nullable();
            $table->string('visa_type')->nullable();
            $table->string('CL_Number')->nullable();
            $table->string('sponsor_name')->nullable();
            $table->string('eid_no')->nullable();
            $table->string('CL_nationality')->nullable();
            $table->string('nationality')->nullable();
            $table->date('wc_date')->nullable();
            $table->string('dw_number')->nullable();
            $table->date('visa_date')->nullable();
            $table->string('incident_type')->nullable();
            $table->date('incident_date')->nullable();
            $table->date('arrived_date')->nullable();
            $table->string('package')->nullable();
            $table->string('sales_comm_status')->nullable();
            $table->text('remark')->nullable();
            $table->integer('inside_country_or_outside')->default(1)->comment('1 = Outside , 2 = Inside');
            $table->string('missing_file')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
