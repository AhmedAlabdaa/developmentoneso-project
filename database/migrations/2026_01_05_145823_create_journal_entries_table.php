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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->integer('journal_id', true);
            $table->date('journal_date');
            $table->text('description')->nullable();
            $table->string('reference_no', 50)->nullable();
            $table->decimal('total_debit', 15);
            $table->decimal('total_credit', 15);
            $table->enum('status', ['Pending', 'Unpaid', 'Paid', 'Partially Paid', 'Overdue', 'Cancelled', 'Hold', 'Draft', 'Approved'])->default('Pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
    }
};
