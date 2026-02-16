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
        Schema::create('journal_headers', function (Blueprint $table) {
            $table->id();
            $table->date('posting_date');

            // 0=draft, 1=posted, 2=void
            $table->tinyInteger('status')->default(0);
            $table->nullableMorphs('source');
            $table->nullableMorphs('pre_src');


            $table->text('note')->nullable();
            $table->json('meta_json')->nullable();

            $table->decimal('total_debit', 18, 2)->default(0);
            $table->decimal('total_credit', 18, 2)->default(0);

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('posted_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('posted_at')->nullable();

            $table->timestamps();

            $table->index('posting_date');
            $table->index('status');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_headers');
    }
};
