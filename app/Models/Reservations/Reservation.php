<?php

namespace App\Models\Reservations;

use App\Models\Account;
use App\Models\City\City;
use App\Models\Lawyer\Lawyer;
use App\Models\Regions\Regions;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservations\ReservationType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservations\ReservationRequest;
use Google\Service\Dfareporting\Resource\Cities;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\ReservationConnectionType;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\Reservations\AvailableReservationDateTime;
use App\Models\ClientReservations\ClientReservationsImportance;

class Reservation extends Model
{
    // use SoftDeletes;

    protected $fillable = [
        'reservation_type_id',
        'importance_id',
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
        'request_status',
        'region_id',
        'city_id',
        'account_id',
        'reserved_from_lawyer_id',
        'transaction_id',
        'transaction_complete',
        'reservation_ended',
        'reservation_code',
        'reservation_started',
        'reservation_started_time',
        'offer_id',
        'for_admin',
        'elite_service_request_id'

    ];

    public function offer()
    {
        return $this->belongsTo(ReservationRequest::class, 'offer_id');
    }
    public function reservationType()
    {
        return $this->belongsTo(ReservationType::class, 'reservation_type_id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id')->withTrashed();
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id')->withTrashed();
    }

    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'reserved_from_lawyer_id')->withTrashed();
    }

    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getFileAttribute($value)
    {
        return !empty($this->attributes['file']) ? asset('uploads/appointments/' . str_replace('\\', '/', $this->attributes['file'])) : null;
    }
}
