<?php

namespace App\Models;

use App\Models\EliteServiceRequest;
use Illuminate\Database\Eloquent\Model;

class EliteServiceRequestFile extends Model
{
    // Specify table name since it does not follow the convention.
    protected $table = 'elite_service_requests_files';
    protected $fillable = [
        'elite_service_request_id',
        'advisory_services_reservations_id',
        'services_reservations_id',
        'reservations_id',
        'file',
        'is_voice',
        'is_reply'
    ];

    protected $appends = ['file'];

    public function eliteServiceRequest()
    {
        return $this->belongsTo(EliteServiceRequest::class);
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file']) ? asset('uploads/elite_service/' . str_replace('\\', '/', $this->attributes['file'])) : null;

    }
}
