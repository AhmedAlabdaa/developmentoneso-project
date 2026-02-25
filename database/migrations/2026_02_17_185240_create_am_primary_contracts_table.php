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
        Schema::create('am_primary_contracts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('crm_id')->constrained('crm')->cascadeOnDelete();
            $table->date('end_date')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>Active, 0=>Inactive');
            $table->tinyInteger('type')->default(1)->comment('1=>p3, 2=>p4');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('am_primary_contracts');
    }
};
