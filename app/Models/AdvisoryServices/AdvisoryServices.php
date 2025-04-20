<?php

namespace App\Models\AdvisoryServices;

use OwenIt\Auditing\Auditable;
use App\Models\PaymentCategoryType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use App\Models\ClientReservations\ClientReservationsImportance;

class AdvisoryServices extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'advisory_services';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($advisoryService) {
            $advisoryServicesAvailableDates = AdvisoryServicesAvailableDates::where('advisory_services_id', $advisoryService->id)->get();
            foreach ($advisoryServicesAvailableDates as $asad) {
                $asad->delete();
            }
            $advisoryServicesTypes = AdvisoryServicesTypes::where('advisory_service_id', $advisoryService->id)->get();
            foreach ($advisoryServicesTypes as $ast) {
                $ast->delete();
            }
        });

    }
    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/advisory_services/' . str_replace('\\', '/', $this->attributes['image'])) : null;
    }


    public function available_dates()
    {
        return $this->hasMany(AdvisoryServicesAvailableDates::class, 'advisory_services_id', 'id');
    }

    public function payment_category()
    {
        return $this->belongsTo(AdvisoryServicesPaymentCategory::class, 'payment_category_id', 'id')->withTrashed();
    }

    public function types()
    {
        return $this->hasMany(AdvisoryServicesTypes::class, 'advisory_service_id', 'id');

    }

    public function payment_category_type()
    {
        return $this->belongsTo(PaymentCategoryType::class, 'payment_category_type_id', 'id');
    }

}
