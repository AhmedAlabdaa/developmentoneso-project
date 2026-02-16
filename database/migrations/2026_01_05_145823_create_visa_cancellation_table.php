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
        Schema::create('visa_cancellation', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->text('reason');
            $table->date('cancellation_date');
            $table->string('proof');
            $table->integer('created_by');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_cancellation');
    }
};
