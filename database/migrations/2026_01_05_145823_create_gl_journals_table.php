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
        Schema::create('gl_journals', function (Blueprint $table) {
            $table->bigIncrements('journal_id');
            $table->date('journal_date');
            $table->string('source_type', 40);
            $table->unsignedBigInteger('source_id');
            $table->string('reference_no', 80)->nullable();
            $table->string('memo')->nullable();
            $table->char('currency_code', 3)->default('AED');
            $table->enum('status', ['POSTED', 'VOID'])->default('POSTED');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['source_type', 'source_id'], 'uq_gl_source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gl_journals');
    }
};
