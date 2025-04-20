<?php

namespace App\Models;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service\ServiceSubCategory;
use App\Models\Reservations\ReservationType;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;

class EliteServiceRequestsProductOffer extends Model
{
    // Specify table name since it does not follow the convention.
    protected $table = 'elite_service_requests_product_offers';

    // Define fillable attributes.
    protected $fillable = [
        'elite_service_request_id',
        'advisory_service_sub_id',
        'advisory_service_sub_price',
        'advisory_service_sub_price_counter',
        'advisory_service_date',
        'advisory_service_date_counter',
        'advisory_service_from_time',
        'advisory_service_from_time_counter',
        'advisory_service_to_time',
        'advisory_service_to_time_counter',
        'service_sub_id',
        'service_sub_price',
        'service_sub_price_counter',
        'reservation_type_id',
        'reservation_price',
        'reservation_price_counter',
        'reservation_date',
        'reservation_date_counter',
        'reservation_from_time',
        'reservation_from_time_counter',
        'reservation_to_time',
        'reservation_to_time_counter',
        'reservation_latitude',
        'reservation_longitude'
    ];

    public function advisoryServiceSub()
    {
        return $this->belongsTo(AdvisoryServicesSubCategory::class, 'advisory_service_sub_id');
    }

    public function serviceSub()
    {
        return $this->belongsTo(Service::class, 'service_sub_id');
    }

    public function reservationType()
    {
        return $this->belongsTo(ReservationType::class, 'reservation_type_id');
    }

    public function eliteServiceRequest()
    {
        return $this->belongsTo(EliteServiceRequest::class, 'elite_service_request_id');
    }
}
