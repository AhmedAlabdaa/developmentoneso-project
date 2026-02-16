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
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reference_no')->nullable();
            $table->string('candidate_name')->nullable();
            $table->string('agreement_type', 50);
            $table->string('agreement_reference_no')->nullable();
            $table->unsignedInteger('candidate_id');
            $table->string('CL_Number', 50);
            $table->string('CN_Number', 50);
            $table->string('reference_of_candidate', 100);
            $table->string('package', 50);
            $table->string('foreign_partner', 100)->nullable();
            $table->unsignedInteger('client_id');
            $table->string('salary')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('contract_signed_copy')->nullable();
            $table->enum('maid_delivered', ['Yes', 'No'])->default('No');
            $table->date('transferred_date');
            $table->string('emp_reference_no')->nullable();
            $table->string('nationality')->nullable();
            $table->text('remarks')->nullable();
            $table->string('marked')->default('No')->comment('No , Yes');
            $table->integer('status')->comment('1 - Pending
2 - Active
3 - Exceeded
4 - Cancelled
5 - Contracted
6 - Rejected
');
            $table->date('cancelled_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->integer('replacement')->default(0);
            $table->string('replaced_by_name')->nullable();
            $table->string('sales_name')->nullable();
            $table->string('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
