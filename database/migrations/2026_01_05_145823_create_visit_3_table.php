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
        Schema::create('visit_3', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->string('tawjeeh_certificate')->nullable();
            $table->date('lc_submission_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('invoice_amount', 10)->nullable();
            $table->string('lc_number')->nullable();
            $table->date('lc_expiry')->nullable();
            $table->text('remarks')->nullable();
            $table->string('proof')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_3');
    }
};
