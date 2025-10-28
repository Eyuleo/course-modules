<?php

namespace App\Services;

use App\Models\ServiceListing;
use App\Models\User;

class ListingService
{
    public function search(array $filters)
    {
        $q = ServiceListing::query()->where('is_published', true);
        if (!empty($filters['q'])) {
            $q->where(function ($qq) use ($filters) {
                $qq->where('title', 'like', '%'.$filters['q'].'%')
                   ->orWhere('description', 'like', '%'.$filters['q'].'%');
            });
        }
        if (!empty($filters['category'])) {
            $q->whereHas('category', function ($c) use ($filters) {
                $c->where('slug', $filters['category']);
            });
        }
        if (!empty($filters['min_price'])) {
            $q->where('price_cents', '>=', (int) $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $q->where('price_cents', '<=', (int) $filters['max_price']);
        }
        if (!empty($filters['delivery_days'])) {
            $q->where('delivery_days', '<=', (int) $filters['delivery_days']);
        }
        return $q->paginate(15);
    }

    public function createListing(User $student, array $data): ServiceListing
    {
        return ServiceListing::create([
            'student_user_id' => $student->id,
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'],
            'price_cents' => (int) $data['price_cents'],
            'currency' => $data['currency'] ?? env('CURRENCY', 'ETB'),
            'delivery_days' => (int) $data['delivery_days'],
            'is_published' => (bool) ($data['is_published'] ?? false),
        ]);
    }
}
