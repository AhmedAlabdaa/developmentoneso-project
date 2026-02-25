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
        Schema::create('govt_transactions_invoices', function (Blueprint $table) {
            $table->string('invoice_number')->primary();
            $table->string('mohre_ref')->nullable();
            $table->date('invoice_date')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('CL_Number')->nullable();
            $table->string('CN_Number')->nullable();
            $table->string('Customer_name')->nullable();
            $table->string('Customer_mobile_no', 20)->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('Sales_name')->nullable();
            $table->decimal('total_amount', 10)->nullable();
            $table->decimal('total_vat', 10)->nullable();
            $table->decimal('net_total', 10)->nullable();
            $table->enum('status', ['Pending', 'Partial Paid', 'Paid', 'Cancelled'])->nullable();
            $table->string('payment_proof')->nullable();
            $table->string('payment_mode')->nullable();
            $table->integer('created_by');
            $table->timestamp('updated_at');
            $table->string('received_amount');
            $table->string('remaining_amount');
            $table->string('customer_type');
            $table->string('payment_note')->nullable();
            $table->decimal('total_center_fee', 10)->default(0);
            $table->decimal('discount_amount', 10)->default(0);
            $table->string('currency', 10)->default('AED');
            $table->date('due_date')->nullable();
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('govt_transactions_invoices');
    }
};
