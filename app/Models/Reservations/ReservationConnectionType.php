<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReservationConnectionType extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'reservation_connection_type';
}
