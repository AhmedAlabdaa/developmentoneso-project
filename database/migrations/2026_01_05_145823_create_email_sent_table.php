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
        Schema::create('email_sent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('to_email', 191)->index();
            $table->string('action', 191);
            $table->string('passport_no', 50)->nullable();
            $table->string('candidate_name', 191)->index();
            $table->string('foreign_partner', 191)->nullable();
            $table->string('ref_no', 100)->nullable();
            $table->date('action_date')->nullable();
            $table->string('file')->nullable();
            $table->text('other')->nullable();
            $table->string('subject');
            $table->string('status', 50);
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_sent');
    }
};
