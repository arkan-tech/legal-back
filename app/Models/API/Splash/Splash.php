<?php

namespace App\Models\API\Splash;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Splash extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'splash';
    protected $guarded = [];

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) ? asset('uploads/api/splash/' . str_replace('\\', '/', $this->attributes['image'])) : null;
    }
}
