<?php

namespace App\Models\JudicialGuide;

use App\Models\City\City;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JudicialGuide extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'judicial_guide';

    protected $fillable = [
        'name',
        'image',
        'working_hours_from',
        'working_hours_to',
        'url',
        'about',
        'sub_category_id',
        'city_id'
    ];

    protected static function booted()
    {
        static::deleting(function ($judicialGuide) {
            $judicialGuide->numbers()->delete();
            $judicialGuide->emails()->delete();
        });
    }
    public function subCategory()
    {
        return $this->belongsTo(JudicialGuideSubCategory::class, 'sub_category_id', 'id');
    }

    public function numbers()
    {
        return $this->hasMany(JudicialGuideNumbers::class, 'judicial_guide_id', 'id');
    }
    public function emails()
    {
        return $this->hasMany(JudicialGuideEmails::class, 'judicial_guide_id', 'id');
    }

    public function getImageAttribute()
    {

        return array_key_exists('image', $this->attributes) && $this->attributes['image'] != "" ? asset('uploads/judicial_guide/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');

    }

    public function getNumbersAttribute()
    {
        return $this->numbers()->get()->map(function ($number) {
            return $number->phone_code . $number->phone_number;
        })->toArray();
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
