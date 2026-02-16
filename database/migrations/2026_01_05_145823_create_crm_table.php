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
        Schema::create('crm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cl');
            $table->string('CL_Number')->nullable();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->string('nationality')->nullable();
            $table->string('state');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('emirates_id');
            $table->string('emergency_contact_person')->nullable();
            $table->string('source')->nullable();
            $table->string('passport_copy')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('id_copy')->nullable();
            $table->string('status')->nullable()->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crm');
    }
};
