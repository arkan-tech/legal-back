<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;

class PaymentCategoryType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "advisory_services_payment_categories_types";

    protected $guarded = [];

    public function generalCategories()
    {
        return $this->hasMany(AdvisoryServicesGeneralCategory::class, 'payment_category_type_id');
    }
}
