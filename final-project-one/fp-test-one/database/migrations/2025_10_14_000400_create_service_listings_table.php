<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('price_cents');
            $table->string('currency', 10)->default(env('CURRENCY', 'ETB'));
            $table->unsignedInteger('delivery_days');
            $table->boolean('is_published')->default(false);
            $table->float('rating_avg')->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();

            $table->index('category_id');
            $table->index('is_published');
            $table->index('student_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_listings');
    }
};
