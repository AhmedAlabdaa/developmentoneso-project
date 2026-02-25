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
        Schema::create('agent_comission', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('agent_name');
            $table->string('cl_number', 100);
            $table->string('cn_number', 100);
            $table->decimal('credit_amount', 15)->nullable()->default(0);
            $table->decimal('debit_amount', 15)->nullable()->default(0);
            $table->enum('status', ['Pending', 'Approved', 'Paid'])->nullable()->default('Pending');
            $table->date('expired_date')->nullable();
            $table->string('incident_no', 100)->nullable();
            $table->text('incident_proof')->nullable();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->integer('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agent_comission');
    }
};
