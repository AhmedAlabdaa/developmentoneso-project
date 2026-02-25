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
        Schema::create('amp3_action_notifies', function (Blueprint $table) {
         
            $table->id();
            $table->date('refund_date')->nullable();
            $table->foreignId('am_contract_movement_id')
            ->constrained('am_contract_movments')
            ->onDelete('cascade');
            $table->tinyInteger('status')->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')
            ->nullable()
            ->constrained('users')
            ->onDelete('cascade');
            $table->foreignId('updated_by')
            ->nullable()
            ->constrained('users')
            ->onDelete('cascade');
            $table->decimal('amount', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amp3_action_notifies');
    }
};
