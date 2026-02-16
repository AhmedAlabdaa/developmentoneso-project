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
        Schema::create('emirated_id', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->date('application_date')->nullable();
            $table->string('application_number')->nullable();
            $table->date('biometric_schedule')->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('invoice_amount', 10)->nullable();
            $table->string('eid_number')->nullable();
            $table->date('eid_expiry')->nullable();
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
        Schema::dropIfExists('emirated_id');
    }
};
