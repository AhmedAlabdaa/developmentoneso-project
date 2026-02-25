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
        Schema::create('payment_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('receipt_number', 50)->unique('uniq_payment_receipts_receipt_number');
            $table->date('receipt_date');
            $table->enum('payer_type', ['customer', 'walkin'])->index('idx_payment_receipts_payer_type');
            $table->unsignedBigInteger('customer_id')->nullable()->index('idx_payment_receipts_customer_id');
            $table->string('walkin_name')->nullable();
            $table->decimal('amount', 12);
            $table->string('payment_method', 100);
            $table->string('reference_no')->nullable();
            $table->string('attachment_path')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Cancelled'])->default('Pending');
            $table->text('notes');
            $table->text('cancel_reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'receipt_date'], 'idx_payment_receipts_status_receipt_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_receipts');
    }
};
