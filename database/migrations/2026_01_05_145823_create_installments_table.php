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
        Schema::create('installments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('reference_no', 50);
            $table->string('agreement_no', 50);
            $table->string('invoice_number')->nullable();
            $table->string('CL_Number', 50);
            $table->string('CN_Number', 50);
            $table->string('customer_name');
            $table->string('employee_name');
            $table->string('passport_no', 100);
            $table->string('contract_duration', 50);
            $table->date('contract_start_date');
            $table->date('contract_end_date');
            $table->string('package', 50);
            $table->decimal('contract_amount', 10);
            $table->integer('number_of_installments');
            $table->integer('paid_installments')->default(0);
            $table->integer('created_by');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
