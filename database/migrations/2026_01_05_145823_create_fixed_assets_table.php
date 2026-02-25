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
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->integer('asset_id', true);
            $table->string('asset_name');
            $table->string('asset_category');
            $table->date('acquisition_date');
            $table->decimal('acquisition_cost', 15);
            $table->enum('depreciation_method', ['Straight Line', 'Declining Balance'])->nullable()->default('Straight Line');
            $table->integer('useful_life_years');
            $table->decimal('salvage_value', 15)->nullable()->default(0);
            $table->decimal('net_book_value', 15)->nullable()->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_assets');
    }
};
