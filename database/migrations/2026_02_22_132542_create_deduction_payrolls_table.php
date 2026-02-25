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
        Schema::create('deduction_payrolls', function (Blueprint $table) {
            $table->id();
            $table->date('deduction_date')->nullable();

            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();

            $table->unsignedSmallInteger('payroll_year');
            $table->unsignedTinyInteger('payroll_month');

            $table->decimal('amount_deduction', 10, 2)->default(0);
            $table->decimal('amount_allowance', 10, 2)->default(0);

            $table->text('note')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();

            $table->index(['employee_id', 'payroll_year', 'payroll_month']);
            $table->index(['payroll_year', 'payroll_month']);
            $table->unique(['employee_id', 'payroll_year', 'payroll_month'], 'deduction_unique_row');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deduction_payrolls');
    }
};
