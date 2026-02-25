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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->enum('role', ['sales', 'finance', 'CHC', 'coordinator']);
            $table->integer('user_id')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('title');
            $table->text('message');
            $table->string('ref_no')->nullable();
            $table->string('CN_Number')->nullable();
            $table->string('CL_Number')->nullable();
            $table->enum('status', ['Read', 'Un Read', 'Action Done'])->default('Un Read');
            $table->integer('action_by')->nullable();
            $table->dateTime('status_updated_time')->nullable();
            $table->string('filePath')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
