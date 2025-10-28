<?php

namespace App\Policies;

use App\Models\MessageThread;
use App\Models\User;

class MessagePolicy
{
    public function view(User $user, MessageThread $thread): bool
    {
        // TODO: tighten to actual participants when relations exist
        return true;
    }
}
