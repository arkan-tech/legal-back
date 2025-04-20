<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'experience_points', 'notification'];
    protected $table = "xp_activities";

    public function getNotificationAttribute()
    {
        return is_null(
            $this->attributes['notification']
        ) ? '' : $this->attributes['notification'];
    }
}
