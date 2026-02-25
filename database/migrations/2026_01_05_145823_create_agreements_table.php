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
        Schema::create('agreements', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('reference_no');
            $table->string('agreement_type');
            $table->integer('candidate_id')->nullable();
            $table->string('CL_Number');
            $table->string('CN_Number');
            $table->string('candidate_name')->nullable();
            $table->string('reference_of_candidate');
            $table->string('ref_no_in_of_previous');
            $table->string('package');
            $table->string('foreign_partner')->nullable();
            $table->string('client_id')->nullable();
            $table->string('payment_method');
            $table->string('total_amount');
            $table->string('monthly_payment')->nullable();
            $table->string('payment_cycle')->nullable();
            $table->string('salary');
            $table->string('visa_type')->nullable();
            $table->string('received_amount');
            $table->string('remaining_amount');
            $table->text('notes')->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_no', 50)->nullable();
            $table->date('passport_expiry_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('payment_proof')->nullable();
            $table->date('agreement_start_date')->nullable();
            $table->date('agreement_end_date')->nullable();
            $table->string('number_of_days')->nullable();
            $table->string('contract_duration')->nullable();
            $table->string('contracted_amount')->nullable();
            $table->date('expected_arrival_date')->nullable();
            $table->integer('created_by');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('status')->comment('1 - Pending
2 - Active
3 - Exceeded
4 - Cancelled
5 - Contracted
6 - Rejected
');
            $table->string('marked')->default('No')->comment('No , Yes');
            $table->string('months_count')->nullable();
            $table->string('current_month_salary')->nullable();
            $table->string('upcoming_payment_date')->nullable();
            $table->string('installment_count')->nullable();
            $table->date('cancelled_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
