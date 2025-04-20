<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Model;
use App\Models\RequestLevels\RequestLevel;
use App\Models\Lawyer\LawyersServicesPrice;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services';

    protected $guarded = [];
    protected static function booted()
    {
        static::deleting(function ($service) {
            $ymtazLevelPrices = $service->ymtaz_levels_prices()->delete();
            $lawyerLevelPrices = LawyersServicesPrice::where('service_id', $service->id)->get();
            foreach ($lawyerLevelPrices as $lawyerLevelPrice) {
                $lawyerLevelPrice->delete();
            }
            ServiceSections::where('service_id', $service->id)->delete();

        });
    }

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/services/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');

    }

    public function section()
    {
        return $this->belongsToMany(
            DigitalGuideCategories::class,
            'service_sections',
            'service_id',
            'section_id'
        );
    }

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(ServiceSubCategory::class, 'sub_category_id', 'id');
    }

    public function request_level()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'request_level_id', 'id');
    }

    public function ymtaz_levels_prices()
    {
        return $this->hasMany(ServiceYmtazLevelPrices::class, 'service_id', 'id');
    }

    public function lawyerPrices()
    {
        return $this->hasMany(LawyersServicesPrice::class, 'service_id', 'id');
    }

}
