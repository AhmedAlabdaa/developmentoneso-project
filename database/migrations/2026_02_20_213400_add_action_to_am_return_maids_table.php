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
        Schema::table('am_return_maids', function (Blueprint $table) {
            $table->tinyInteger('action')->nullable()->after('status')->comment('1: pending, 2: replacement, 3: refund, 4: due amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('am_return_maids', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }
};
