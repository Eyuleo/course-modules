<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('student_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('listing_id')->constrained('service_listings')->cascadeOnDelete();
            $table->text('scope');
            $table->json('requirements');
            $table->unsignedInteger('budget_cents');
            $table->string('currency', 10);
            $table->dateTime('deadline_at');
            $table->enum('state', ['draft','pending_funding','awaiting_acceptance','in_progress','in_review','completed','canceled','disputed'])->default('draft');
            $table->dateTime('due_at')->nullable();
            $table->dateTime('auto_approve_at')->nullable();
            $table->timestamps();

            $table->index('client_user_id');
            $table->index('student_user_id');
            $table->index('state');
            $table->index('listing_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
