<?php

namespace App\Models\Client;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequestRates extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_service_requests_rates';
    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(ServiceUser::class, 'client_id', 'id');
    }

}
