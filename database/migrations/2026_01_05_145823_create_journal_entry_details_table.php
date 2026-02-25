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
        Schema::create('journal_entry_details', function (Blueprint $table) {
            $table->integer('detail_id', true);
            $table->integer('journal_id')->index('journal_id');
            $table->integer('account_code')->index('account_id');
            $table->decimal('debit_amount', 15)->nullable()->default(0);
            $table->decimal('credit_amount', 15)->nullable()->default(0);
            $table->text('description')->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entry_details');
    }
};
