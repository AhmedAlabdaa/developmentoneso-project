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
        Schema::create('replacement_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contract_number');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('old_candidate_id');
            $table->unsignedBigInteger('new_candidate_id');
            $table->string('name');
            $table->string('nationality');
            $table->string('passport_no');
            $table->string('reference_no');
            $table->string('agreement_no');
            $table->string('old_invoice_number');
            $table->string('new_invoice_number');
            $table->date('replacement_date');
            $table->decimal('total_amount', 15);
            $table->string('replacement_proof');
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replacement_history');
    }
};
