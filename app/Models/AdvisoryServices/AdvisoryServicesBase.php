<?php

namespace App\Models\AdvisoryServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AdvisoryServicesBase extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;
    protected $table = 'advisory_services_base';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($advisoryServiceBase) {

            $aspcs = AdvisoryServicesPaymentCategory::where('advisory_service_base_id', $advisoryServiceBase->id)->get();
            foreach ($aspcs as $aspc) {
                $aspc->delete();
            }
        });
    }

    public function advisory_services_payment_categories()
    {
        return $this->hasMany(AdvisoryServicesPaymentCategory::class, 'advisory_service_base_id');
    }
}
