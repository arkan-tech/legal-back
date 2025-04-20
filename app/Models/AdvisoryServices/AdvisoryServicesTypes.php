<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class AdvisoryServicesTypes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'advisory_services_types';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($advisoryServiceType) {
            $advisoryServiceType->advisory_services_prices()->delete();
            $advisoryServiceType->lawyerSections()->detach();
        });
    }
    public function advisoryService()
    {
        return $this->belongsTo(AdvisoryServices::class, 'advisory_service_id', 'id');
    }

    public function advisory_services_prices()
    {
        return $this->hasMany(AdvisoryServicesPrices::class, 'advisory_service_id', 'id');
    }

    public function lawyerSections()
    {
        return $this->belongsToMany(DigitalGuideCategories::class, 'advisory_services_lawyer_sections', 'advisory_service_type_id', 'lawyer_section_id');
    }
}
