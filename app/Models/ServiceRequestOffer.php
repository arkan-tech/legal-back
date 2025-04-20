<?php

namespace App\Models;

use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Model;
use App\Models\ServicesRequestsAndReservationsFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class ServiceRequestOffer extends Model
{
    use HasFactory;

    protected $table = 'service_request_offers';

    protected $fillable = [
        'service_id',
        'importance_id',
        'lawyer_id',
        'price',
        'status',
        'account_id',
        'description'
    ];


    public function account()
    {
        // return $this->belongsTo(Account::class, 'account_id');
        return $this->belongsTo(ServiceUser::class, 'account_id');
        // return Account::find($this->account_id)
        // ?? ServiceUser::find($this->account_id);
    }
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id');
    }

    public function lawyer()
    {
        // return $this->belongsTo(Account::class, 'lawyer_id');
        return $this->belongsTo(ServiceUser::class, 'lawyer_id');
    }

    public function files()
    {
        return $this->hasMany(ServicesRequestsAndReservationsFile::class, 'service_request_offer_id');
    }
}
