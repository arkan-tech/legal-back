<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AdvisoryServicesAvailableDatesTimes extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;
    protected $table = 'advisory_services_available_dates_times';
    protected $guarded = [];
}
