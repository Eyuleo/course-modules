<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('message_threads', function (Blueprint $table) {
            $table->id();
            $table->enum('context_type', ['inquiry','order']);
            $table->unsignedBigInteger('context_id');
            $table->foreignId('created_by_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['context_type','context_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_threads');
    }
};
