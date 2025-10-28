<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Review> */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'author_id' => User::factory(),
            'subject_user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(3, 5),
            'comment' => $this->faker->optional()->sentence(),
        ];
    }
}
