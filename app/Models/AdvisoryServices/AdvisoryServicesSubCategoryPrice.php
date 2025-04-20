<?php

namespace App\Models\AdvisoryServices;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\ClientReservations\ClientReservationsImportance;

class AdvisoryServicesSubCategoryPrice extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'advisory_services_sub_categories_prices';
    protected $fillable = ['sub_category_id', 'duration', 'importance_id', 'price', 'is_hidden', 'lawyer_id'];

    public function subCategory()
    {
        return $this->belongsTo(AdvisoryServicesSubCategory::class, 'sub_category_id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'lawyer_id');
    }
}
