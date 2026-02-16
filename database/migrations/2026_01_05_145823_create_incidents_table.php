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
        Schema::create('incidents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('incident_category');
            $table->unsignedBigInteger('candidate_id')->index('candidate_id');
            $table->string('candidate_name');
            $table->string('employer_name')->nullable();
            $table->string('reference_no');
            $table->string('ref_no');
            $table->string('country');
            $table->string('company');
            $table->string('branch');
            $table->string('nationality');
            $table->text('incident_reason');
            $table->date('incident_expiry_date')->nullable();
            $table->text('other_reason')->nullable();
            $table->string('proof')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
