<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','skills','bio','education','portfolio_url',
    ];

    protected $casts = [
        'skills' => 'array',
        'education' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
