<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisoryServicesReservationFiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'reservation_id',
        'file',
        'is_reply',
        'is_voice',
    ];

    public function reservation()
    {
        return $this->belongsTo(AdvisoryServicesReservations::class, 'reservation_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/advisory_services/reservations/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }

}
