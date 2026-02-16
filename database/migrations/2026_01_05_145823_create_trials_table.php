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
        Schema::create('trials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('candidate_id');
            $table->string('reference_no');
            $table->string('candidate_name');
            $table->string('trial_type');
            $table->unsignedBigInteger('client_id');
            $table->string('CL_Number');
            $table->string('CN_Number');
            $table->date('trial_start_date');
            $table->date('trial_end_date');
            $table->integer('number_of_days');
            $table->string('package');
            $table->enum('trial_status', ['Active', 'Confirmed', 'Change Status', 'Sales Return', 'Incident', 'Trial Return', 'Contracted']);
            $table->date('active_date')->nullable();
            $table->date('confirmed_date')->nullable();
            $table->date('change_status_date')->nullable();
            $table->date('trial_return_date')->nullable();
            $table->date('sales_return_date')->nullable();
            $table->date('incident_date')->nullable();
            $table->string('incident_type')->nullable();
            $table->string('agreement_reference_no');
            $table->decimal('agreement_amount', 15);
            $table->text('remarks')->nullable();
            $table->string('incident_proof')->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('change_status_proof')->nullable();
            $table->integer('created_by');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trials');
    }
};
