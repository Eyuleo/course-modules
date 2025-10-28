<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class OrderService
{
    public function createFromListing(User $client, ServiceListing $listing, array $data): Order
    {
        return Order::create([
            'client_user_id' => $client->id,
            'student_user_id' => $listing->student_user_id,
            'listing_id' => $listing->id,
            'scope' => $data['scope'] ?? '',
            'requirements' => $data['requirements'] ?? [],
            'budget_cents' => (int) ($data['budget_cents'] ?? $listing->price_cents),
            'currency' => $data['currency'] ?? $listing->currency,
            'deadline_at' => $data['deadline_at'] ?? now()->addDays($listing->delivery_days),
            'state' => Order::STATE_PENDING_FUNDING,
        ]);
    }

    public function transition(Order $order, string $to): Order
    {
        $valid = [
            Order::STATE_PENDING_FUNDING,
            Order::STATE_AWAITING_ACCEPTANCE,
            Order::STATE_IN_PROGRESS,
            Order::STATE_IN_REVIEW,
            Order::STATE_COMPLETED,
            Order::STATE_CANCELED,
            Order::STATE_DISPUTED,
        ];
        if (!in_array($to, $valid, true)) {
            throw new InvalidArgumentException('Invalid state: '.$to);
        }
        DB::transaction(function () use ($order, $to) {
            $order->update(['state' => $to]);
        });
        return $order->refresh();
    }
}
