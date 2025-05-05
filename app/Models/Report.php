<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'images',
        'job_id',
        'latitude',
        'longitude',
    ];

    // You can add relationships here if needed, for example:
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }
}
