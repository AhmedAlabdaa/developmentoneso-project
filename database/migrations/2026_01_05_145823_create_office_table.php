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
        Schema::create('office', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('candidate_id')->nullable();
            $table->string('type', 20)->nullable();
            $table->string('category', 50)->nullable();
            $table->date('returned_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('ica_proof')->nullable();
            $table->integer('overstay_days')->nullable()->default(0);
            $table->decimal('fine_amount', 10)->nullable()->default(0);
            $table->string('passport_status', 50)->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
            $table->integer('status')->nullable()->default(1)->comment('1 = show , 0 = Not show who moved to somewhere');
            $table->integer('update_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office');
    }
};
