<?php

namespace App\Models\LawyerReservations;

use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\ClientReservations\ClientReservationsTypes;
use App\Models\Lawyer\Lawyer;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerReservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_reservations';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'reserved_lawyer_id', 'id');
    }

    public function typeRel()
    {
        return $this->belongsTo(ClientReservationsTypes::class, 'type', 'id');
    }

    public function importanceRel()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance', 'id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

    public function ClientAdvisoryServicesReservations()
    {
        return $this->belongsTo(LawyerAdvisoryServicesReservations::class, 'lawyer_advisory_services_reservation_id', 'id');
    }

}
