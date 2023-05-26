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
        Schema::create('receives', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contract_id');
            $table->foreignId('card_id');
            $table->foreignId('company_id');
            $table->foreignId('customer_id');

            $table->enum('type', ['deposit', 'check']);
            $table->string('origin')->nullable();
            $table->string('amount')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->nullable();
            $table->text('desc')->nullable();
            $table->string('serial_number')->nullable();

            $table->dateTime('paid_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receives');
    }
};
