<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Order> */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $listing = ServiceListing::factory();
        return [
            'client_user_id' => User::factory(),
            'student_user_id' => User::factory(),
            'listing_id' => $listing,
            'scope' => $this->faker->paragraph(),
            'requirements' => ['files' => []],
            'budget_cents' => $this->faker->numberBetween(1000, 100000),
            'currency' => env('CURRENCY', 'ETB'),
            'deadline_at' => now()->addDays(7),
            'state' => Order::STATE_DRAFT,
        ];
    }
}
