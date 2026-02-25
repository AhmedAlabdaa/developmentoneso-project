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
        Schema::create('acc_employee_map', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unique('uq_acc_emp_employee');
            $table->string('employee_name', 200);
            $table->string('package_code', 20)->index('idx_acc_emp_pkg');
            $table->string('passport_no', 60)->unique('uq_acc_emp_passport');
            $table->string('emirates_id', 60)->unique('uq_acc_emp_emirates');
            $table->string('oca_account_code', 20)->unique('uq_acc_emp_oca');
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
        Schema::dropIfExists('acc_employee_map');
    }
};
