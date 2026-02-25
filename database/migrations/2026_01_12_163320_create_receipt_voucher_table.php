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
        Schema::create('receipt_voucher', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 10)->unique();
            $table->nullableMorphs('source');
            $table->json('attachments')->nullable();
            $table->enum('status', ['draft', 'posted', 'void'])->default('draft');
            $table->tinyInteger('payment_mode')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipt_voucher');
    }
};
