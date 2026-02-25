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
        Schema::create('visit_2', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->date('applied_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('mb_number')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('invoice_amount', 10)->nullable();
            $table->string('personal_number')->nullable();
            $table->text('remarks')->nullable();
            $table->string('proof')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_2');
    }
};
