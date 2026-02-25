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
        Schema::create('new_candidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CN_Number')->nullable();
            $table->bigInteger('reference_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('slug')->nullable()->unique('uniq_slug');
            $table->string('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_title_ar')->nullable();
            $table->string('meta_keywords_ar', 1000)->nullable();
            $table->string('meta_description_ar', 1000)->nullable();
            $table->string('passport_no')->nullable()->unique('uq_new_candidates_passport_no');
            $table->string('passport_issue_date')->nullable();
            $table->string('passport_issue_place')->nullable();
            $table->string('nationality')->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('foreign_partner')->nullable();
            $table->string('branch_in_uae')->nullable();
            $table->integer('age')->nullable();
            $table->string('gender', 50)->nullable();
            $table->string('salary')->nullable();
            $table->string('sponsorship')->nullable();
            $table->text('work_skill_general_description')->nullable();
            $table->string('contract_duration')->nullable();
            $table->string('religion')->nullable();
            $table->string('english_skills')->nullable();
            $table->string('arabic_skills')->nullable();
            $table->string('applied_position')->nullable();
            $table->text('work_skill')->nullable();
            $table->text('skill_description')->nullable();
            $table->string('education_level')->nullable();
            $table->string('marital_status')->nullable();
            $table->integer('number_of_children')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->string('preferred_package')->nullable();
            $table->string('desired_country')->nullable();
            $table->string('coc_status')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->text('candidate_current_address')->nullable();
            $table->date('labour_id_date')->nullable();
            $table->string('labour_id_number')->nullable();
            $table->string('family_name')->nullable();
            $table->string('family_contact_number_1')->nullable();
            $table->string('family_contact_number_2')->nullable();
            $table->string('relationship_with_candidate')->nullable();
            $table->text('family_current_address')->nullable();
            $table->string('current_status')->nullable();
            $table->integer('visa_status')->nullable()->default(0);
            $table->dateTime('hold_date')->nullable();
            $table->dateTime('selected_date')->nullable();
            $table->dateTime('wc_date')->nullable();
            $table->dateTime('wc_added_date')->nullable();
            $table->dateTime('visa_date')->nullable();
            $table->dateTime('visa_added_date')->nullable();
            $table->string('uid_number')->nullable();
            $table->string('entry_permit_number')->nullable();
            $table->string('visa_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->dateTime('arrived_date')->nullable();
            $table->dateTime('arrived_added_date')->nullable();
            $table->dateTime('transfer_date')->nullable();
            $table->dateTime('transfer_added_date')->nullable();
            $table->dateTime('office_date')->nullable();
            $table->dateTime('trial_date')->nullable();
            $table->dateTime('confirmed_date')->nullable();
            $table->dateTime('change_status_date')->nullable();
            $table->integer('sales_name')->nullable();
            $table->string('visa_type')->nullable();
            $table->date('rejected_date')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('updated_by')->nullable();
            $table->integer('inside_status')->nullable()->comment('1 = Office, 2 = For Trial, 3 = Confirm, 4 = Change Status (CS)');
            $table->date('arrived_in_office_date')->nullable();
            $table->string('accomodation')->nullable();
            $table->string('passport_status')->nullable();
            $table->date('visa_issue_date')->nullable();
            $table->date('visa_expiry_date')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('cancellation_date')->nullable();
            $table->string('dw_number')->nullable();
            $table->string('overstay_days')->nullable();
            $table->string('fine_amount')->nullable();
            $table->text('wc_date_remark')->nullable();
            $table->text('incident_before_visa_remark')->nullable();
            $table->text('visa_date_remark')->nullable();
            $table->text('incident_after_visa_remark')->nullable();
            $table->string('updateArrivedDateModalremarks')->nullable();
            $table->text('incident_after_departure_remark')->nullable();
            $table->text('incident_after_arrival_remark')->nullable();
            $table->text('transfer_date_remark')->nullable();
            $table->dateTime('backout_date')->nullable();
            $table->dateTime('incident_before_visa_date')->nullable();
            $table->dateTime('incident_after_visa_date')->nullable();
            $table->string('hospital_name')->nullable();
            $table->date('medical_date')->nullable();
            $table->string('medical_status')->nullable();
            $table->dateTime('medical_status_date')->nullable();
            $table->dateTime('coc_status_date')->nullable();
            $table->date('coc_registration_date')->nullable();
            $table->date('coc_issued_date')->nullable();
            $table->date('coc_expired_on')->nullable();
            $table->dateTime('l_submitted_date')->nullable();
            $table->dateTime('l_issued_date')->nullable();
            $table->dateTime('departure_date')->nullable();
            $table->dateTime('incident_after_departure_date')->nullable();
            $table->dateTime('incident_after_arrival_date')->nullable();
            $table->integer('appeal')->nullable()->default(0);
            $table->dateTime('appeal_date')->nullable();
            $table->text('medical_remarks')->nullable();
            $table->text('coc_remarks')->nullable();
            $table->text('l_submitted_date_remarks')->nullable();
            $table->text('l_issued_date_remarks')->nullable();
            $table->text('departure_date_remarks')->nullable();
            $table->date('l_submission_date')->nullable();
            $table->date('pulled_date')->nullable();
            $table->date('insurance_approved_date')->nullable();
            $table->integer('status')->nullable()->default(1)->comment('1 = Show 
2 = Don\'t Show');
            $table->date('pcc_date')->nullable();
            $table->string('pcc_status')->nullable();
            $table->date('embassy_submitted_date')->nullable();
            $table->string('embassy_payment_proof')->nullable();
            $table->date('embassy_released_date')->nullable();
            $table->date('insurance_date')->nullable();
            $table->string('insurance_status')->nullable();

            $table->unique(['reference_no', 'ref_no'], 'uq_new_candidates_reference_ref');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_candidates');
    }
};
