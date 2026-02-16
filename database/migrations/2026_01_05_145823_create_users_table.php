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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->string('role')->default('HRM');
            $table->integer('nationality')->nullable();
            $table->integer('status_changed')->default(0);
            $table->string('api_token', 80)->nullable()->unique('api_token');
            $table->timestamp('api_token_created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
