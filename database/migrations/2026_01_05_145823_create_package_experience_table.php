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
        Schema::create('package_experience', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id')->index('candidate_id');
            $table->string('country');
            $table->integer('experience_years');
            $table->integer('experience_months')->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('package_experience');
    }
};
