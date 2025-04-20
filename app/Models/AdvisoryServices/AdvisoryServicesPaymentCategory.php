<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdvisoryServicesPaymentCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'advisory_services_payment_categories';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($advisoryServicePaymentCategory) {
            $advisoryServices = AdvisoryServices::where("payment_category_id", $advisoryServicePaymentCategory->id)->get();
            foreach ($advisoryServices as $as) {
                $as->delete();
            }

        });
    }
    public function advisory_services()
    {
        return $this->hasMany(AdvisoryServices::class, 'payment_category_id');
    }

    public function advisory_services_base()
    {
        return $this->belongsTo(AdvisoryServicesBase::class, 'advisory_service_base_id', 'id');
    }
}
