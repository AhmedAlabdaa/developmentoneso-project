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
        Schema::create('acc_customer_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('crm_customer_id')->unique('uq_acc_cust_customer');
            $table->string('cl_number', 60)->unique('uq_acc_cust_cl');
            $table->string('emirates_id', 60)->unique('uq_acc_cust_emirates');
            $table->string('customer_name', 200);
            $table->string('ar_account_code', 20)->unique('uq_acc_cust_ar');
            $table->char('currency_code', 3)->default('AED');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_customer_map');
    }
};
