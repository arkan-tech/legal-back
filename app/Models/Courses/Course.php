<?php

namespace App\Models\Courses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';
    protected $guarded = [];

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/courses/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');

    }
}
