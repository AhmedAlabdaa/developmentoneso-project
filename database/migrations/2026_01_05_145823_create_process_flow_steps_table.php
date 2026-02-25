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
        Schema::create('process_flow_steps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('step_no')->unique('uniq_step_no');
            $table->string('title', 100);
            $table->string('note')->nullable();
            $table->unsignedTinyInteger('visit_no')->nullable();
            $table->boolean('is_incident')->default(false);
            $table->string('icon_class', 64)->default('bi bi-circle');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('process_flow_steps');
    }
};
