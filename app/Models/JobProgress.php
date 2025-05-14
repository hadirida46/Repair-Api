<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class JobProgress extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'specialist_comment',
        'image_path',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

}
