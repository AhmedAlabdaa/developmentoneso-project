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
        Schema::create('employees_additional_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->nullable()->index('employees_additional_files_employee_id_idx');
            $table->unsignedBigInteger('visa_stage_id')->nullable()->index('employees_additional_files_stage_id_idx');
            $table->integer('step_id')->nullable();
            $table->string('file_path', 512);
            $table->string('file_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees_additional_files');
    }
};
