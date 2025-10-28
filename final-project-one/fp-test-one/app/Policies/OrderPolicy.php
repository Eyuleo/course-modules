<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        return in_array($user->id, [$order->client_user_id, $order->student_user_id], true);
    }

    public function transition(User $user, Order $order): bool
    {
        return in_array($user->id, [$order->client_user_id, $order->student_user_id], true);
    }
}
