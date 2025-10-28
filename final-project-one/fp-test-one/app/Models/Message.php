<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['thread_id','sender_id','body','attachments','flagged'];

    protected $casts = [
        'attachments' => 'array',
        'flagged' => 'boolean',
    ];

    public function thread()
    {
        return $this->belongsTo(MessageThread::class, 'thread_id');
    }
}
