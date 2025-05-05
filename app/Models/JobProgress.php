<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property-read \App\Models\Job|null $job
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JobProgress query()
 * @mixin \Eloquent
 */
class JobProgress extends Model
{
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

}
