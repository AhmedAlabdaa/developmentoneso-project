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
        Schema::create('v_erp_gl', function (Blueprint $table) {
            $table->char('currency_code', 3)->nullable();
            $table->date('journal_date')->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->string('memo')->nullable();
            $table->string('reference_no', 80)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('source_type', 40)->nullable();
            $table->enum('status', ['POSTED', 'VOID'])->nullable();
            $table->decimal('total_credit', 40)->nullable();
            $table->decimal('total_debit', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_erp_gl');
    }
};
