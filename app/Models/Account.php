<?php

namespace App\Models;

use App\Models\Package;
use App\Models\City\City;
use App\Models\AdminUsers;
use Illuminate\Support\Str;
use OwenIt\Auditing\Auditable;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\AccountExperience;
use App\Models\Country\Nationality;
use App\Models\LawyerAdditionalInfo;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Google\Service\CCAIPlatform\AdminUser;
use App\Models\EliteServicePricingCommittee;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Account extends Authenticatable implements JWTSubject, AuditableContract
{
    use HasFactory, Auditable, SoftDeletes;

    protected $table = "accounts";
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'phone',
        'phone_code',
        'password',
        'region_id',
        'city_id',
        'country_id',
        'nationality_id',
        'status',
        'type',
        'account_type',
        'profile_complete',
        'profile_photo',
        'gender',
        'longitude',
        'latitude',
        'referred_by',
        'email_confirmation',
        'phone_confirmation',
        'email_otp',
        'phone_otp',
        'phone_otp_expires_at',
        'email_otp_expires_at',
        'email_verified_at',
        'phone_verified_at',
        'last_seen'
    ];
    protected $hidden = ['password'];
    protected $appends = ['profile_photo_url'];

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

    public function lawyerDetails()
    {
        return $this->hasOne(LawyerAdditionalInfo::class);
    }
    public function admin()
    {
        return $this->hasOne(AdminUsers::class);
    }
    public function isAdmin()
    {
        return $this->admin()->exists();
    }
    public function gamification()
    {
        return $this->hasMany(Gamification::class);
    }
    public function referralCode()
    {
        return $this->hasOne(ReferralCode::class, 'account_id', 'id');
    }
    public function clientGamification()
    {
        return Gamification::where('account_id', $this->id)->where('gamification_type', 'client')->with('account')->first();
    }
    public function getJWTCustomClaims()
    {
        return [];
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
    public function injectToken($token)
    {
        $this->token = $token;
    }
    public function getProfilePhotoUrlAttribute()
    {
        if (!is_null($this->profile_photo)) {
            return asset('uploads/account/profile_photo/' . str_replace('\\', '/', $this->profile_photo));
        } elseif ($this->gender === "Male") {
            return asset('Male.png');
        } elseif ($this->gender === "Female") {
            return asset('Female.png');
        } else {
            return asset('uploads/person.png');
        }
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function transformAudit(array $data): array
    {
        $data['user_type'] = $this->user_type;
        return $data;
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');

    }
    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');

    }

    public function subscriptions()
    {
        return $this->belongsToMany(Package::class, 'package_subscriptions', 'account_id', 'package_id')->withPivot('start_date', 'end_date', 'consumed_services', 'consumed_advisory_services', 'consumed_reservations', 'transaction_complete');
    }

    // public function assignedPermissions()
    // {
    //     return $this->hasMany(LawyerAssignedPermission::class);
    // }
    public function experiences()
    {
        return $this->hasMany(AccountExperience::class);
    }

    public function pricingCommittee()
    {
        return $this->hasOne(EliteServicePricingCommittee::class, 'account_id', 'id');
    }
}