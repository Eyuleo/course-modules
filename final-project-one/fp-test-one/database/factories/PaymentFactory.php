<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Payment> */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'stripe_payment_intent_id' => 'pi_'.str()->random(24),
            'amount_cents' => $this->faker->numberBetween(1000, 100000),
            'currency' => env('CURRENCY', 'ETB'),
            'status' => 'requires_payment_method',
        ];
    }
}
