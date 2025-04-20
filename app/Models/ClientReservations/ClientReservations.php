<?php

namespace App\Models\ClientReservations;

use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientReservations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_reservations';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
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
        return $this->belongsTo(ClientAdvisoryServicesReservations::class, 'client_advisory_services_reservation_id', 'id');
    }

}
