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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reference_no');
            $table->string('type');
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->unsignedInteger('number_of_candidates');
            $table->decimal('total_amount', 10);
            $table->tinyInteger('status')->comment('1 - Pending, 2 - Approved, 3 - Cancelled');
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
