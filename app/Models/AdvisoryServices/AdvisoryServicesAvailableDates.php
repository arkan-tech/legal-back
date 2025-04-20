<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AdvisoryServicesAvailableDates extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'advisory_services_available_dates';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($availableDate) {
            $availableDate->available_times()->delete();
        });
    }
    public function available_times()
    {
        return $this->hasMany(AdvisoryServicesAvailableDatesTimes::class, 'advisory_services_available_dates_id', 'id');
    }
}
