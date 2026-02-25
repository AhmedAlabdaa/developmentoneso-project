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
        Schema::create('acc_settings', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->string('ar_parent_code', 20);
            $table->string('oca_parent_code', 20);
            $table->string('revenue_code', 20);
            $table->string('vat_output_code', 20);
            $table->string('bank_code', 20);
            $table->decimal('vat_rate', 9, 6)->default(0.05);
            $table->char('currency_code', 3)->default('AED');
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_settings');
    }
};
