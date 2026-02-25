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
        Schema::create('govt_transactions_invoice_items', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('invoice_number')->nullable()->index('invoice_number');
            $table->string('service_name')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('amount', 10)->nullable();
            $table->decimal('tax', 10)->nullable();
            $table->decimal('total', 10)->nullable();
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->string('dw_number')->nullable();
            $table->decimal('center_fee', 10)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('govt_transactions_invoice_items');
    }
};
