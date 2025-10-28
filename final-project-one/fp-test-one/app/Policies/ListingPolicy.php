<?php

namespace App\Policies;

use App\Models\ServiceListing;
use App\Models\User;

class ListingPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole('student');
    }

    public function update(User $user, ServiceListing $listing): bool
    {
        return $user->id === $listing->student_user_id;
    }
}
