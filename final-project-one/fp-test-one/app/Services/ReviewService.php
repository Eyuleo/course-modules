<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Review;
use App\Models\User;

class ReviewService
{
    public function createReview(Order $order, User $author, int $rating, ?string $comment = null): Review
    {
        return Review::create([
            'order_id' => $order->id,
            'author_id' => $author->id,
            'subject_user_id' => $author->id === $order->client_user_id ? $order->student_user_id : $order->client_user_id,
            'rating' => $rating,
            'comment' => $comment,
        ]);
    }
}
