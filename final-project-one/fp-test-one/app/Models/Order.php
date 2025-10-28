<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATE_DRAFT = 'draft';
    public const STATE_PENDING_FUNDING = 'pending_funding';
    public const STATE_AWAITING_ACCEPTANCE = 'awaiting_acceptance';
    public const STATE_IN_PROGRESS = 'in_progress';
    public const STATE_IN_REVIEW = 'in_review';
    public const STATE_COMPLETED = 'completed';
    public const STATE_CANCELED = 'canceled';
    public const STATE_DISPUTED = 'disputed';

    protected $fillable = [
        'client_user_id','student_user_id','listing_id','scope','requirements','budget_cents','currency','deadline_at','state','due_at','auto_approve_at',
    ];

    protected $casts = [
        'requirements' => 'array',
        'deadline_at' => 'datetime',
        'due_at' => 'datetime',
        'auto_approve_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_user_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }

    public function listing()
    {
        return $this->belongsTo(ServiceListing::class, 'listing_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
