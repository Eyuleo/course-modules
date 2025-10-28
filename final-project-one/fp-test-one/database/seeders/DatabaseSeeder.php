<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use App\Models\Category;
use App\Models\ServiceListing;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Guard against missing tables during early setup
    if (Schema::hasTable('roles') && Schema::hasTable('users')) {
            // Create base roles if not exist
            foreach (['student', 'client', 'admin'] as $roleName) {
                Role::findOrCreate($roleName);
            }

            // Create demo users with roles if table exists
            $student = User::firstOrCreate(
                ['email' => 'student@example.com'],
                ['name' => 'Demo Student', 'password' => 'password']
            );
            $student->assignRole('student');

            $client = User::firstOrCreate(
                ['email' => 'client@example.com'],
                ['name' => 'Demo Client', 'password' => 'password']
            );
            $client->assignRole('client');

            if (Schema::hasTable('categories') && Schema::hasTable('service_listings')) {
                $category = Category::firstOrCreate(['slug' => 'design'], ['name' => 'Design']);
                ServiceListing::factory()->create([
                    'student_user_id' => $student->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
