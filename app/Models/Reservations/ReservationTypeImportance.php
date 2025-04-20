<?php

namespace App\Models\Reservations;

use App\Models\Account;
use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservations\ReservationType;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservations\AvailableReservation;
use App\Models\Reservations\ReservationImportance;

class ReservationTypeImportance extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'reservation_types_importance';

    protected static function booted()
    {
        static::deleting(function ($reservationTypeImportance) {
            $availableReservations = $reservationTypeImportance->availableReservations();
            foreach ($availableReservations as $availableReservation) {
                $availableReservation->delete();
            }
        });
    }
    public function reservationType()
    {
        return $this->belongsTo(ReservationType::class, 'reservation_types_id');
    }

    public function reservationImportance()
    {
        return $this->belongsTo(ReservationImportance::class, 'reservation_importance_id');
    }

    public function lawyer()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function availableReservations()
    {
        return $this->hasMany(AvailableReservation::class, 'reservation_type_importance_id', 'id');
    }
}
