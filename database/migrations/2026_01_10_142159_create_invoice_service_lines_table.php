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
        Schema::create('invoice_service_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_account_id')->constrained('ledger_of_accounts')->cascadeOnDelete();
            $table->foreignId('invoice_service_id')->constrained('invoice_services')->cascadeOnDelete();
            $table->decimal('amount', 10, 2)->nullable();
            $table->boolean('vatable')->default(false);
            $table->string('note')->nullable();
            $table->tinyInteger('source_amount')->default(1)->comment('1 from the amount, from maid cost');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_service_lines');
    }
};
