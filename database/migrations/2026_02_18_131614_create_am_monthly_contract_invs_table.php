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
        Schema::create('am_monthly_contract_invs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('serial_no');
            $table->foreignId('am_monthly_contract_id')
                  ->constrained('am_contract_movments')
                  ->cascadeOnDelete();
            $table->foreignId('crm_id')
                  ->constrained('crm')
                  ->cascadeOnDelete();
            $table->foreignId('am_installment_id')
                  ->constrained('am_installments')
                  ->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->json('attachment')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_monthly_contract_invs');
    }
};
