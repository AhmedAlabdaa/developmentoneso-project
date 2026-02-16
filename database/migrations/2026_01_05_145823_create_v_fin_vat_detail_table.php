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
        Schema::create('v_fin_vat_detail', function (Blueprint $table) {
            $table->date('journal_date')->nullable();
            $table->decimal('net_amount', 40)->nullable();
            $table->string('reference_no', 80)->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->decimal('total_amount', 40)->nullable();
            $table->decimal('vat_amount', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_vat_detail');
    }
};
