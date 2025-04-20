<?php

namespace App\Models\AdvisoryCommittee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class AdvisoryCommittee extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $table = 'advisorycommittees';
    protected $guarded = [];
    protected $appends = ['image'];
    public function getImageAttribute()
    {
        return !empty($this->attributes['Image']) ? asset('uploads/AdvisoryCommittee/' . str_replace('\\', '/', $this->attributes['Image'])) : asset('uploads/person.png');
    }
}
