<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','author_id','subject_user_id','rating','comment'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
