<?php

namespace App\Models;

use App\Models\AppointmentsRequests;
use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentsReservations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentsRequestsAndReservationsFiles extends Model
{
    use HasFactory;

    protected $table = 'appointments_requests_and_reservations_files';

    protected $fillable = [
        'appointment_request_id',
        'appointment_reservation_id',
        'file',
        'is_voice',
        'is_reply',
    ];

    public function appointmentRequest()
    {
        return $this->belongsTo(AppointmentsRequests::class, 'appointment_request_id');
    }

    public function appointmentReservation()
    {
        return $this->belongsTo(AppointmentsReservations::class, 'appointment_reservation_id');
    }

    public function getFileAttribute($value)
    {
        return !empty($this->attributes['file']) ? asset('uploads/appointments/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
