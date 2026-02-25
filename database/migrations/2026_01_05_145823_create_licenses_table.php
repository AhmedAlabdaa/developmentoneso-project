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
        Schema::create('licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('file_name');
            $table->string('file');
            $table->string('file_path');
            $table->string('document_type');
            $table->string('document_number')->unique();
            $table->date('document_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->boolean('renewal_required')->default(true);
            $table->enum('status', ['Valid', 'Expired', 'Pending Renewal', 'Revoked'])->default('Valid');
            $table->unsignedBigInteger('uploaded_by')->index('licenses_uploaded_by_foreign');
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
