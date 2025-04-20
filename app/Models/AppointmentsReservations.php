<?php

namespace App\Models;

use App\Models\AppointmentsSubPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class AppointmentsReservations extends Model
{
    use HasFactory;

    protected $table = 'appointments_reservations';

    protected $fillable = [
        'account_id',
        'reserved_from_lawyer_id',
        'sub_category_price_id',
        'price',
        'transaction_id',
        'transaction_complete',
        'reservation_ended',
        'reservation_ended_time',
        'request_status',
    ];

    public function subPrice()
    {
        return $this->belongsTo(AppointmentsSubPrices::class, 'sub_category_price_id');
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
