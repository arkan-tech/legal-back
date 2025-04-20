<?php

namespace App\Models\LawyerAdvisoryServices;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerAdvisoryServicesReservationsRates extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_advisory_services_reservations_rates';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

}
