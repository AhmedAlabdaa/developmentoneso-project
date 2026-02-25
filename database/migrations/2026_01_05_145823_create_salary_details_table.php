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
        Schema::create('salary_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->decimal('basic', 10);
            $table->decimal('housing', 10);
            $table->decimal('transportation', 10);
            $table->decimal('other_allowances', 10);
            $table->decimal('total', 10);
            $table->text('remarks')->nullable();
            $table->string('proof')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};
