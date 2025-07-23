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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('midtrans_order_id');
            $table->string('transaction_id');
            $table->string('method');
            $table->string('payment_type');
            $table->string('va_number');
            $table->text('pdf_url');
            $table->string('fraud_status');
            $table->dateTime('payment_date');
            $table->enum('status', ['success', 'pending', 'failed'])->default('pending');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
