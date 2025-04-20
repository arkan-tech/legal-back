<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicesRequestsAndReservationsFile extends Model
{
    protected $fillable = ['service_request_offer_id', 'reservation_id', 'file', 'is_voice', 'is_reply'];

    public function serviceRequestOffer()
    {
        return $this->belongsTo(ServiceRequestOffer::class, 'service_request_offer_id');
    }

    public function reservation()
    {
        return $this->belongsTo(ServicesReservations::class, 'reservation_id');
    }

    public function getFileAttribute($value)
    {
        return !empty($this->attributes['file']) ? asset('uploads/services-requests/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
