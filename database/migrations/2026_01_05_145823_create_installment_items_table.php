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
        Schema::create('installment_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('installment_id')->nullable();
            $table->string('particular');
            $table->decimal('amount', 10);
            $table->dateTime('payment_date')->nullable();
            $table->boolean('invoice_generated')->default(false);
            $table->string('reference_no', 100)->nullable();
            $table->string('payment_proof')->nullable();
            $table->dateTime('paid_date')->nullable();
            $table->string('status', 50)->default('pending');
            $table->string('invoice_number', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_items');
    }
};
