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
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voucher_no', 191)->unique('voucher_no');
            $table->date('voucher_date');
            $table->string('payee', 191);
            $table->string('mode_of_payment', 191);
            $table->string('reference_no', 191)->nullable();
            $table->decimal('total_debit', 15)->default(0);
            $table->decimal('total_credit', 15)->default(0);
            $table->enum('status', ['Pending', 'Approved', 'Cancelled'])->default('Pending');
            $table->string('created_by', 191)->nullable();
            $table->string('approved_by', 191)->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->string('cancelled_by', 191)->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->text('narration')->nullable();
            $table->json('lines_json');
            $table->string('attachments')->nullable();
            $table->timestamps();

            $table->index(['voucher_date', 'status'], 'idx_pv_date_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};
