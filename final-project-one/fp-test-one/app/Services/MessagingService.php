<?php

namespace App\Services;

use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Order;
use App\Models\ServiceListing;
use App\Models\User;

class MessagingService
{
    public function getOrCreateThread(string $context, int $id, User $createdBy): MessageThread
    {
        return MessageThread::firstOrCreate([
            'context_type' => $context,
            'context_id' => $id,
        ], [
            'created_by_id' => $createdBy->id,
        ]);
    }

    public function listMessages(MessageThread $thread)
    {
        return $thread->messages()->latest()->paginate(20);
    }

    public function sendMessage(MessageThread $thread, User $user, string $body, array $attachments = []): Message
    {
        return $thread->messages()->create([
            'sender_id' => $user->id,
            'body' => $body,
            'attachments' => $attachments,
        ]);
    }
}
