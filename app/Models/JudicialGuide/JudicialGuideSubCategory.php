<?php

namespace App\Models\JudicialGuide;

use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JudicialGuide\JudicialGuideSubEmails;
use App\Models\JudicialGuide\JudicialGuideSubNumbers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\JudicialGuide\JudicialGuideMainCategory;

class JudicialGuideSubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'judicial_guide_sub_category';

    protected $fillable = [
        'name',
        'main_category_id',
        'locationUrl',
        'address',
        'region_id',

    ];

    protected static function booted()
    {
        static::deleting(function ($subCategory) {
            $judicialGuides = $subCategory->judicialGuides()->get();
            foreach ($judicialGuides as $judicialGuide) {
                $judicialGuide->delete();
            }
        });
    }
    public function mainCategory()
    {
        return $this->belongsTo(JudicialGuideMainCategory::class, 'main_category_id', 'id');
    }

    public function judicialGuides()
    {
        return $this->hasMany(JudicialGuide::class, 'sub_category_id', 'id');
    }

    public function numbers()
    {
        return $this->hasMany(JudicialGuideSubNumbers::class, 'judicial_guide_sub_id', 'id');
    }
    public function emails()
    {
        return $this->hasMany(JudicialGuideSubEmails::class, 'judicial_guide_sub_id', 'id');
    }
    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'id');
    }
}
