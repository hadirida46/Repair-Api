<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialist_id',
        'feedback', 
    ];

    /**
     * Get the user that owns the feedback.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the specialist that the feedback is for.
     */
    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
}
