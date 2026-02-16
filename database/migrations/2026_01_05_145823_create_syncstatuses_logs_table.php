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
        Schema::create('syncstatuses_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('partner_db', 80);
            $table->enum('run_result', ['success', 'failed']);
            $table->unsignedInteger('changes_count');
            $table->timestamp('run_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syncstatuses_logs');
    }
};
