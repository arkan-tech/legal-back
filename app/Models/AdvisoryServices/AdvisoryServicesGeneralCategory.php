<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PaymentCategoryType;

class AdvisoryServicesGeneralCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'payment_category_type_id'];

    public function subCategories()
    {
        return $this->hasMany(AdvisoryServicesSubCategory::class, 'general_category_id');
    }

    public function paymentCategoryType()
    {
        return $this->belongsTo(PaymentCategoryType::class, 'payment_category_type_id');
    }
}
