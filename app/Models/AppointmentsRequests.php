<?php

namespace App\Models;

use App\Models\AppointmentsSubPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AppointmentsRequestsAndReservationsFiles;
use App\Models\ClientReservations\ClientReservationsImportance;

class AppointmentsRequests extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments_requests';

    protected $fillable = [
        'appointment_sub_id',
        'importance_id',
        'account_id',
        'lawyer_id',
        'price',
        'status',
        'description',
    ];

    public function subPrice()
    {
        return $this->belongsTo(AppointmentsSubPrices::class, 'appointment_sub_id');
    }
    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'importance_id');
    }
    public function files()
    {
        return $this->hasMany(AppointmentsRequestsAndReservationsFiles::class, 'appointment_request_id');
    }
    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'reserved_from_lawyer_id');
    }
    public function client()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
