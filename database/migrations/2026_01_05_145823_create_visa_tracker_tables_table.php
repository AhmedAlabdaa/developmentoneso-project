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
        Schema::create('visa_tracker_tables', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('table_name');
            $table->string('field_name');
            $table->string('field_type');
            $table->boolean('is_nullable');
            $table->string('default_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visa_tracker_tables');
    }
};
