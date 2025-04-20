<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerWorkDays;
use App\Models\Lawyer\LawyersAdvisorys;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkingHours\WorkingHours;
use App\Models\Specialty\GeneralSpecialty;
use App\Models\Specialty\AccurateSpecialty;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class LawyerAdditionalInfo extends Model implements AuditableContract
{
    use HasFactory, Auditable, SoftDeletes;

    protected $table = "lawyer_additional_info";

    protected $appends = ['national_id_image', 'logo', 'degree_certificate', 'cv_file', 'license_file', 'company_license_file'];
    protected $fillable = [
        "account_id",
        'degree',
        'degree_certificate',
        'about',
        'national_id',
        'national_id_image',
        'is_advisor',
        'license_no',
        'license_image',
        'advisory_id',
        'show_in_advisory_website',
        'show_at_digital_guide',
        'is_special',
        'day',
        'month',
        'year',
        'general_specialty',
        'accurate_specialty',
        'functional_cases',
        'cv_file',
        'digital_guide_subscription',
        'company_name',
        'company_licenses_no',
        'company_license_file',
        'identity_type',
        'other_identity_type',
        'logo'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    // public function lawyer()
    // {
    //     return $this->belongsTo(Account::class, 'account_id');
    // }

    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class, 'account_id', 'id');
    }
    public function functional_cases_rel()
    {
        return $this->belongsTo(FunctionalCases::class, 'functional_cases', 'id');
    }
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'lawyer_languages', 'account_details_id');
    }
    public function degreeRel()
    {
        return $this->belongsTo(Degree::class, 'degree', 'id');
    }
    public function AccurateSpecialty()
    {
        return $this->belongsTo(AccurateSpecialty::class, 'accurate_specialty', 'id');
    }

    public function GeneralSpecialty()
    {
        return $this->belongsTo(GeneralSpecialty::class, 'general_specialty', 'id');
    }
    public function WorkTimes()
    {
        return $this->hasMany(WorkingHours::class, 'account_details_id', 'id');
    }
    public function lawyerAdvisories()
    {
        return $this->hasMany(LawyersAdvisorys::class, 'account_details_id', 'id');
    }

    public function getLogoAttribute()
    {
        return !empty($this->attributes['logo']) || !is_null($this->attributes['logo']) ? asset('uploads/account/logo/' . $this->attributes['logo']) : asset('uploads/person.png');
    }
    public function getCompanyLicenseFileAttribute()
    {
        return !empty($this->attributes['company_license_file']) || !is_null($this->attributes['company_license_file']) ? asset('uploads/account/company_license_file/' . $this->attributes['company_license_file']) : null;
    }

    public function getNationalIdImageAttribute()
    {
        return !empty($this->attributes['national_id_image']) || !is_null($this->attributes['national_id_image']) ? asset('uploads/account/national_id_image/' . $this->attributes['national_id_image']) : null;
    }

    public function getLicenseFileAttribute()
    {
        return !empty($this->attributes['license_image']) || !is_null($this->attributes['license_image']) ? asset('uploads/account/license_image/' . $this->attributes['license_image']) : null;
    }

    public function getCVAttribute()
    {
        return !empty($this->attributes['cv_file']) || !is_null($this->attributes['cv_file']) ? asset('uploads/account/cv_file/' . $this->attributes['cv_file']) : null;
    }
    public function getCVFileAttribute()
    {
        return !empty($this->attributes['cv_file']) || !is_null($this->attributes['cv_file']) ? asset('uploads/account/cv_file/' . $this->attributes['cv_file']) : null;
    }
    public function getDegreeCertificateAttribute()
    {
        return !empty($this->attributes['degree_certificate']) || !is_null($this->attributes['degree_certificate']) ? asset('uploads/account/degree_certificate/' . $this->attributes['degree_certificate']) : null;
    }
    public function SectionsRel()
    {
        return $this->belongsToMany(DigitalGuideCategories::class, 'lawyer_sections', 'account_details_id', 'section_id')
            ->withPivot('licence_no', 'licence_file');
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
        return 'lawyer';
    }
    public function transformAudit(array $data): array
    {
        $data['user_type'] = $this->user_type;
        return $data;
    }

    public function scopeNotAdvisor($query)
    {
        return $query->where('is_advisor', false);
    }
}
