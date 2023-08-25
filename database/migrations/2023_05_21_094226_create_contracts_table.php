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
            $table->id();

            $table->foreignId('customer_id');
            $table->foreignId('company_id');

            $table->string('name')->nullable();
            $table->text('desc')->nullable();
            $table->text('draft')->nullable();
            $table->enum('financial_status', ['paid', 'billed'])->default('billed');
            $table->enum('contract_status', ['progress', 'finished', 'canceled', 'renewal'])->default('progress');
            $table->text('total_price')->nullable();
            $table->text('payable')->nullable();
            $table->text('advance_payment')->nullable();
            $table->text('installments_total_price')->nullable(); // total_price - advance_payment ;
            $table->string('type')->nullable();
            $table->string('contract_number')->nullable() ;
            $table->string('period')->nullable();
            $table->dateTime('remind_at')->nullable();
            $table->dateTime('signed_at')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('canceled_at')->nullable();
            $table->dateTime('expired_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
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
