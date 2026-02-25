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
        Schema::create('gl_journal_lines', function (Blueprint $table) {
            $table->bigIncrements('line_id');
            $table->unsignedBigInteger('journal_id');
            $table->integer('line_no');
            $table->string('account_code', 20)->index('idx_gl_lines_account');
            $table->decimal('debit', 18)->default(0);
            $table->decimal('credit', 18)->default(0);
            $table->enum('subledger_type', ['CUSTOMER', 'EMPLOYEE', 'NONE'])->default('NONE');
            $table->unsignedBigInteger('subledger_id')->nullable();
            $table->string('memo')->nullable();
            $table->char('currency_code', 3)->default('AED');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['journal_id', 'line_no'], 'uq_gl_lines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gl_journal_lines');
    }
};
