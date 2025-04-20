<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;

class AdvisoryServicesSubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'general_category_id', 'min_price', 'max_price', 'is_active'];

    public function generalCategory()
    {
        return $this->belongsTo(AdvisoryServicesGeneralCategory::class, 'general_category_id');
    }

    public function levels()
    {
        return $this->hasMany(AdvisoryServicesSubCategoryPrice::class, 'sub_category_id');
    }

    public function prices()
    {
        return $this->hasMany(AdvisoryServicesSubCategoryPrice::class, 'sub_category_id');
    }
}
