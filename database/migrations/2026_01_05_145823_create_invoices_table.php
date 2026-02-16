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
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('invoice_id', true);
            $table->string('invoice_number', 50);
            $table->string('agreement_reference_no')->nullable();
            $table->integer('customer_id');
            $table->string('reference_no')->nullable();
            $table->string('CL_Number');
            $table->string('CN_Number', 244);
            $table->enum('invoice_type', ['Tax', 'Proforma', 'Installment'])->nullable()->default('Tax');
            $table->string('payment_method')->nullable();
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('total_amount', 15);
            $table->decimal('received_amount', 15);
            $table->decimal('discount_amount', 15)->nullable()->default(0);
            $table->decimal('tax_amount', 15)->nullable()->default(0);
            $table->decimal('balance_due', 15);
            $table->enum('status', ['Pending', 'Unpaid', 'Paid', 'Partially Paid', 'Overdue', 'Cancelled', 'Hold', 'COD', 'Replacement'])->nullable()->default('Unpaid');
            $table->string('notes')->nullable();
            $table->date('upcoming_payment_date')->nullable();
            $table->string('payment_proof')->nullable();
            $table->integer('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
