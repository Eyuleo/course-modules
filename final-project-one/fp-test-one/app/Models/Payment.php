<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id','stripe_payment_intent_id','stripe_transfer_id','amount_cents','currency','status','last_error','captured_at','refunded_cents',
    ];

    protected $casts = [
        'last_error' => 'array',
        'captured_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
