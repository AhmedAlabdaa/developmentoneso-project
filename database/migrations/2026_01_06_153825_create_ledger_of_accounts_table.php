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
        Schema::create('ledger_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('class')->default(0);
            $table->tinyInteger('sub_class')->default(0);
            $table->string('group')->nullable();   
            $table->tinyInteger('spacial')->default(0);
            $table->enum('type', ['dr', 'cr'])->default('dr');  
            $table->string('note')->nullable(); 
           
        
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_of_accounts');
    }
};
