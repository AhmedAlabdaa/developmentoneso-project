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
        Schema::create('v_fin_vat_summary', function (Blueprint $table) {
            $table->bigInteger('invoices')->nullable();
            $table->string('period', 7)->nullable();
            $table->decimal('revenue', 40)->nullable();
            $table->decimal('vat_output', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_vat_summary');
    }
};
