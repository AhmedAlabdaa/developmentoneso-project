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
        Schema::create('v_fin_journal_lines', function (Blueprint $table) {
            $table->string('account_code', 20)->nullable();
            $table->string('account_name', 200)->nullable();
            $table->decimal('credit', 18)->nullable();
            $table->char('currency_code', 3)->nullable();
            $table->decimal('debit', 18)->nullable();
            $table->unsignedBigInteger('journal_id')->nullable();
            $table->unsignedBigInteger('line_id')->nullable();
            $table->integer('line_no')->nullable();
            $table->string('memo')->nullable();
            $table->unsignedBigInteger('subledger_id')->nullable();
            $table->enum('subledger_type', ['CUSTOMER', 'EMPLOYEE', 'NONE'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_journal_lines');
    }
};
