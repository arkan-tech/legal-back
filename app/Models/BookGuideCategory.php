<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookGuideCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
    ];

    protected $appends = [
        'name',
    ];

    public function bookGuides()
    {
        return $this->hasMany(BookGuide::class, 'category_id');
    }

    public function getNameAttribute()
    {
        return $this->getName(app()->getLocale());
    }

    public function getName($locale = 'en')
    {
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }
}
