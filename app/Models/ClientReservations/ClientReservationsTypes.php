<?php

namespace App\Models\ClientReservations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientReservationsTypes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_reservations_types';
    protected $guarded = [];
}
