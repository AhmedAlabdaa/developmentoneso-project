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
        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->dropForeign(['candidate_id']);
        });

        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->renameColumn('candidate_id', 'employee_id');
        });

        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
        });

        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->renameColumn('employee_id', 'candidate_id');
        });

        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->foreign('candidate_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();
        });
    }
};

