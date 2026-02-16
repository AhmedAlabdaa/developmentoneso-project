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
        Schema::create('typing_tran_gov_invs', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no' , 50);
            $table->string('gov_dw_no' , 50)->nullable(); 
            $table->unsignedBigInteger('maid_id')->nullable();
            $table->decimal('amount_received', 10, 2)->default(0);
            $table->decimal('amount_of_invoice', 10, 2)->default(0);
            $table->json('gov_inv_attachments')->nullable();
            $table->softDeletes();
            

 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('typing_tran_gov_invs');
    }
};
