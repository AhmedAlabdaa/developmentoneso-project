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
        Schema::create('acc_invoice_column_map', function (Blueprint $table) {
            $table->string('table_name', 64)->primary();
            $table->string('pk_col', 64)->nullable();
            $table->string('invoice_no_col', 64)->nullable();
            $table->string('invoice_date_col', 64)->nullable();
            $table->string('customer_id_col', 64)->nullable();
            $table->string('invoice_type_col', 64)->nullable();
            $table->string('status_col', 64)->nullable();
            $table->string('total_col', 64)->nullable();
            $table->string('net_col', 64)->nullable();
            $table->string('vat_col', 64)->nullable();
            $table->string('received_col', 64)->nullable();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_invoice_column_map');
    }
};
