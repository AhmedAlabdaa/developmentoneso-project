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
        Schema::create('visit_1', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('candidate_id');
            $table->string('ol_type')->nullable();
            $table->date('ol_expiry')->nullable();
            $table->string('st_number')->nullable();
            $table->string('mb_number')->nullable();
            $table->string('invoice_no')->nullable();
            $table->date('paid_date')->nullable();
            $table->decimal('invoice_amount', 10)->nullable();
            $table->text('remarks')->nullable();
            $table->string('proof')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_1');
    }
};
