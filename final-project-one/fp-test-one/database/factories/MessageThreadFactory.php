<?php

namespace Database\Factories;

use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<MessageThread> */
class MessageThreadFactory extends Factory
{
    protected $model = MessageThread::class;

    public function definition(): array
    {
        return [
            'context_type' => 'order',
            'context_id' => 1,
            'created_by_id' => User::factory(),
        ];
    }
}
