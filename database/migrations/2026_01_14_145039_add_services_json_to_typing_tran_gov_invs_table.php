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
        Schema::table('typing_tran_gov_invs', function (Blueprint $table) {
            $table->json('services_json')->nullable()->after('gov_dw_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('typing_tran_gov_invs', function (Blueprint $table) {
            $table->dropColumn('services_json');
        });
    }
};
