<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ServiceListing> */
class ServiceListingFactory extends Factory
{
    protected $model = ServiceListing::class;

    public function definition(): array
    {
        return [
            'student_user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price_cents' => $this->faker->numberBetween(1000, 50000),
            'currency' => env('CURRENCY', 'ETB'),
            'delivery_days' => $this->faker->numberBetween(1, 30),
            'is_published' => true,
            'rating_avg' => 0,
            'rating_count' => 0,
        ];
    }
}
