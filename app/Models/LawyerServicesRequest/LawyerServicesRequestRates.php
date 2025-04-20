<?php

namespace App\Models\LawyerServicesRequest;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerServicesRequestRates extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_service_requests_rates';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Lawyer::class, 'lawyer_id', 'id');
    }

}
