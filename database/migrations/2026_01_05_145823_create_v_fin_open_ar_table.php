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
        Schema::create('v_fin_open_ar', function (Blueprint $table) {
            $table->string('ar_account_code', 20)->nullable();
            $table->string('cl_number', 60)->nullable();
            $table->unsignedBigInteger('crm_customer_id')->nullable();
            $table->string('customer_name', 200)->nullable();
            $table->decimal('open_balance', 41)->nullable();
            $table->decimal('total_invoiced', 40)->nullable();
            $table->decimal('total_received', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_open_ar');
    }
};
