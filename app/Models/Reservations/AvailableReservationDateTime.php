<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservations\AvailableReservation;

class AvailableReservationDateTime extends Model
{
    use SoftDeletes;
    protected $table = "available_reservations_date_time";
    protected $guarded = [];

    public function availableReservation()
    {
        return $this->belongsTo(AvailableReservation::class, 'reservation_id');
    }
}
