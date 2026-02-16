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
        Schema::create('v_fin_trial_balance', function (Blueprint $table) {
            $table->string('account_code', 20)->nullable();
            $table->string('account_name', 200)->nullable();
            $table->decimal('net_balance', 41)->nullable();
            $table->decimal('total_credit', 40)->nullable();
            $table->decimal('total_debit', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('v_fin_trial_balance');
    }
};
