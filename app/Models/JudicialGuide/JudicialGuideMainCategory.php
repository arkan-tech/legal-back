<?php

namespace App\Models\JudicialGuide;

use App\Models\Country\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JudicialGuide\JudicialGuideSubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JudicialGuideMainCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'judicial_guide_main_category';

    protected $fillable = [
        'name',
        'country_id'
    ];
    protected static function booted()
    {
        static::deleting(function ($mainCategory) {
            $subCategories = $mainCategory->subCategories()->get();
            foreach ($subCategories as $subCategory) {
                $subCategory->delete();
            }
        });
    }
    public function subCategories()
    {
        return $this->hasMany(JudicialGuideSubCategory::class, 'main_category_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
