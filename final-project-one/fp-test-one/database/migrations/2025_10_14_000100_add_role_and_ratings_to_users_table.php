<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['student','client','admin'])->default('client')->after('email');
            }
            if (!Schema::hasColumn('users', 'rating_avg')) {
                $table->float('rating_avg')->default(0)->after('remember_token');
            }
            if (!Schema::hasColumn('users', 'rating_count')) {
                $table->unsignedInteger('rating_count')->default(0)->after('rating_avg');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'rating_avg')) {
                $table->dropColumn('rating_avg');
            }
            if (Schema::hasColumn('users', 'rating_count')) {
                $table->dropColumn('rating_count');
            }
        });
    }
};
