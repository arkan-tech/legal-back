<?php

namespace App\Models\Reservations;

use App\Models\Account;
use App\Models\City\City;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationType;
use App\Models\ClientReservations\ClientReservationsImportance;

class ReservationRequest extends Model
{
    protected $table = 'reservation_requests';
    protected $fillable = [
        'reservation_type_id',
        'importance_id',
        'account_id',
        'lawyer_id',
        'price',
        'description',
        'file',
        'longitude',
        'latitude',
        'lawyer_longitude',
        'lawyer_latitude',
        'day',
        'from',
        'to',
        'hours',
        'status',
        'region_id',
        'city_id',
        'elite_service_request_id'
    ];

    public function reservationType()
    {
        return $this->belongsTo(ReservationType::class, 'reservation_type_id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'lawyer_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id');
    }
    public function getFileAttribute($value)
    {
        return !empty($this->attributes['file']) ? asset('uploads/appointments/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }
    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'offer_id', 'id');
    }
}
