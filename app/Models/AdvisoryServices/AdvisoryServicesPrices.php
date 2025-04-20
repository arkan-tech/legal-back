<?php

namespace App\Models\AdvisoryServices;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class AdvisoryServicesPrices extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'advisory_services_prices';
    protected $guarded = [];

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'client_reservations_importance_id', 'id');
    }
    public function advisory_service()
    {
        return $this->belongsTo(AdvisoryServicesTypes::class, 'advisory_service_id', 'id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
