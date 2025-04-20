<?php

namespace App\Models\AdvisoryServices;

use App\Models\ClientReservations\ClientReservationsImportance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAdvisoryServicesAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_advisory_services_reservation_appointment';
    protected $guarded = [];

    public function advisory_services_reservation(){
        return $this->hasOne(ClientAdvisoryServicesReservations::class,'id','client_advisory_services_reservation_id');
    }

}
