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
            $table->string('cn_number')->nullable()->after('candidate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journal_tran_lines', function (Blueprint $table) {
            $table->dropColumn('cn_number');
        });
    }
};
