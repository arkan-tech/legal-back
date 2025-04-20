<?php

namespace App\Models\WorkingHours;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class WorkingHours extends Model implements AuditableContract
{
    use HasFactory, Auditable;

    protected $table = 'work_times';
    public function auditableEvents()
    {
        return [
            'created',
            'updated',
            'deleted',
        ];
    }
    protected $fillable = [
        'service',
        'dayOfWeek',
        'from',
        'to',
        'minsBetween',
        'isRepeatable',
        'noOfRepeats',
        'account_details_id'
    ];

}
