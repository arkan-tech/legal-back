<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservations\ReservationTypeImportance;
use App\Models\Reservations\AvailableReservationDateTime;

class AvailableReservation extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($availableReservation) {
            $availableReservation->availableDateTime()->delete();
        });
    }
    public function reservationTypeImportance()
    {
        return $this->belongsTo(ReservationTypeImportance::class, 'reservation_type_importance_id');
    }

    public function availableDateTime()
    {
        return $this->hasOne(AvailableReservationDateTime::class, 'reservation_id');
    }
}
