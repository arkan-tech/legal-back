<?php

namespace App\Models\LawyerAdvisoryServices;

use App\Models\ClientReservations\ClientReservationsImportance;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerAdvisoryServicesAppointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_advisory_services_reservation_appointment';
    protected $guarded = [];

    public function advisory_services_reservation(){
        return $this->hasOne(LawyerAdvisoryServicesReservations::class,'id','lawyer_advisory_services_reservation_id');
    }

}
