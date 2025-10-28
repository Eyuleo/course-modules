<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageThread extends Model
{
    use HasFactory;

    protected $fillable = ['context_type','context_id','created_by_id'];

    public function messages()
    {
        return $this->hasMany(Message::class, 'thread_id');
    }
}
