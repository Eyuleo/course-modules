<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_user_id','category_id','title','description','price_cents','currency','delivery_days','is_published','rating_avg','rating_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
