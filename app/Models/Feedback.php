<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';

    protected $fillable = [
        'specialist_id', 'review',
    ];

    // Define the relationship to the User model (specialist)
    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
}
