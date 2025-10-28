<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('stripe_payment_intent_id')->unique();
            $table->string('stripe_transfer_id')->nullable();
            $table->unsignedInteger('amount_cents');
            $table->string('currency', 10);
            $table->string('status');
            $table->json('last_error')->nullable();
            $table->dateTime('captured_at')->nullable();
            $table->unsignedInteger('refunded_cents')->default(0);
            $table->timestamps();

            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
