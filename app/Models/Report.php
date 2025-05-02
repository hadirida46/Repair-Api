<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Fillable fields
    protected $fillable = [
        'user_id',
        'specialist_id',
        'title',
        'description',
        'status',
        'location',
        'images', // if you store images as JSON or a string
        // add any other fields used in your reports table
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    // If you have images as JSON in a single column
    protected $casts = [
        'images' => 'array',
    ];
}
