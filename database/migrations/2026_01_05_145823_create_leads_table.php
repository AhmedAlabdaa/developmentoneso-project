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
        Schema::create('leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('respond_id')->nullable()->unique('respond_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('sales_name')->nullable();
            $table->string('sales_email')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->default('New');
            $table->dateTime('status_date_time')->nullable();
            $table->string('package')->nullable();
            $table->string('nationality')->nullable();
            $table->string('emirate')->nullable();
            $table->string('negotiation')->nullable();
            $table->string('lifecycle')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
