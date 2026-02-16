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
        Schema::create('payroll_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_id')->index('payroll_id');
            $table->string('CN_Number');
            $table->string('agreement_reference_no');
            $table->decimal('salary_amount', 10);
            $table->decimal('payable_amount', 10);
            $table->unsignedInteger('number_of_days');
            $table->date('agreement_start_date');
            $table->date('agreement_end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payroll_details');
    }
};
