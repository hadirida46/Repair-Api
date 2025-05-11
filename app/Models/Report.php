<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialist_id',
        'title',
        'description',
        'images',
        'latitude',
        'longitude',
        'location',
        'specialist_type',
        "status",
    ];public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }
    

   
}
