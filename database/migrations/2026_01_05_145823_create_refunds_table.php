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
        Schema::create('refunds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('refund_no', 50)->nullable()->index('idx_refunds_refund_no');
            $table->string('reference_no', 50)->nullable()->index('idx_refunds_reference_no');
            $table->string('agreement_reference_no', 50)->index('idx_refunds_agreement_ref');
            $table->string('contract_reference_no', 50)->nullable()->index('idx_refunds_contract_ref');
            $table->string('invoice_number', 50)->nullable()->index('idx_refunds_invoice_number');
            $table->decimal('amount', 12)->default(0);
            $table->string('currency', 10)->nullable();
            $table->string('refund_method', 50)->nullable();
            $table->date('refund_date')->nullable()->index('idx_refunds_refund_date');
            $table->string('bank_name', 100)->nullable();
            $table->string('iban', 50)->nullable();
            $table->text('reason')->nullable();
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
