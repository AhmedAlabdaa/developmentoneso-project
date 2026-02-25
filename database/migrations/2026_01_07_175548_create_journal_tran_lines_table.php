<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('journal_tran_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journal_header_id')
                ->constrained('journal_headers')
                ->cascadeOnDelete();

            $table->foreignId('candidate_id')
                ->nullable()
                ->constrained('employees')
                ->cascadeOnDelete();

            $table->foreignId('ledger_id')
                ->constrained('ledger_of_accounts')
                ->cascadeOnDelete();

            $table->decimal('debit', 18, 2)->default(0);
            $table->decimal('credit', 18, 2)->default(0);

            $table->text('note')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_tran_lines');
    }
};
