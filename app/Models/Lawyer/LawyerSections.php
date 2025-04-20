<?php

namespace App\Models\Lawyer;

use App\Models\Account;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\LawyerAdditionalInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class LawyerSections extends Model implements AuditableContract
{
    use HasFactory, SoftDeletes, Auditable;

    protected $append = ['licence_file'];
    protected $table = 'lawyer_sections';
    protected $guarded = [];

    public function lawyer()
    {
        return $this->belongsTo(LawyerAdditionalInfo::class, 'account_details_id', ownerKey: 'id');
    }
    public function section()
    {
        return $this->belongsTo(DigitalGuideCategories::class, 'section_id', ownerKey: 'id');
    }
    public function getLicenceFileAttribute()
    {
        return !empty($this->attributes['licence_file']) || !is_null($this->attributes['licence_file']) ? asset('uploads/account/license_image/' . $this->attributes['licence_file']) : null;
    }

    public function auditableEvents()
    {
        return [
            'created',
            'updated',
            'deleted',
        ];
    }
    public function getUserTypeAttribute()
    {
        return 'account';
    }
    public function transformAudit(array $data): array
    {
        $data['user_type'] = $this->user_type;
        return $data;
    }
}
