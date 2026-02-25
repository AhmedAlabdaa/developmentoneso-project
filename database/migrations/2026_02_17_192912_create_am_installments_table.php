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
        Schema::create('am_installments', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('am_movment_id')
                  ->constrained('am_contract_movments')
                  ->cascadeOnDelete();
            $table->text('note')->nullable();
            $table->tinyInteger('status')
                  ->default(1)
                  ->comment('1=>Pending, 2=>Invoiced');

            $table->decimal('amount', 10, 2)->default(0);
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
        Schema::dropIfExists('am_installments');
    }
};
