<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{
    public function createPaymentIntent(Order $order, int $amountCents): Payment
    {
        // Placeholder for Stripe integration; will be implemented in US2
        return Payment::create([
            'order_id' => $order->id,
            'stripe_payment_intent_id' => 'pi_'.str()->random(24),
            'amount_cents' => $amountCents,
            'currency' => $order->currency,
            'status' => 'requires_payment_method',
        ]);
    }

    public function capture(Order $order): void
    {
        // Placeholder for capture logic
    }

    public function refund(Order $order, ?int $amountCents = null): void
    {
        // Placeholder for refund logic
    }
}
