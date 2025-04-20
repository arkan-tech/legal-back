<?php

namespace App\Models\Lawyer;

use App\Models\EliteServicePricingCommittee;
use App\Models\LawyerAdditionalInfo;
use Carbon\Carbon;
use App\Models\Rank;
use App\Models\Level;
use App\Models\Point;
use App\Models\Activity;
use App\Models\Language;
use App\Models\UserRank;
use App\Models\City\City;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\ReferralCode;
use App\Models\Degree\Degree;
use App\Models\ExperienceLog;
use OwenIt\Auditing\Auditable;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\StreakMilestone;
use App\Models\Country\Nationality;
use App\Models\Districts\Districts;
use App\Models\Lawyer\LawyerSections;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Lawyer\LawyersAdvisorys;
use Nagy\LaravelRating\Traits\Rateable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\Specialty\GeneralSpecialty;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Specialty\AccurateSpecialty;
use LevelUp\Experience\Concerns\HasStreaks;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FunctionalCases\FunctionalCases;
use LevelUp\Experience\Concerns\GiveExperience;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Controllers\PushNotificationController;
use App\Http\Resources\API\Lawyer\LawyerServicesPrice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;


class Lawyer extends Authenticatable implements JWTSubject, AuditableContract
{
    use Rateable, Notifiable, HasFactory, SoftDeletes, Auditable;

    //use Notifiable, HasFactory;

    protected $table = 'lawyers';

    protected $hidden = ['password'];
    protected $guarded = [];

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
    //Start Relations

    public function city_rel()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }

    public function functional_cases_rel()
    {
        return $this->belongsTo(FunctionalCases::class, 'functional_cases', 'id');
    }

    public function district_rel()
    {
        return $this->belongsTo(Districts::class, 'district', 'id');
    }
    public function lawyerDetails()
    {
        // return $this->hasOne(LawyerAdditionalInfo::class);
        return $this->hasOne(LawyerAdditionalInfo::class, 'account_id', 'id');

    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function pricingCommittee()
    {
        return $this->hasOne(EliteServicePricingCommittee::class, 'account_id', 'id');
    }
    public function nationality_rel()
    {
        return $this->belongsTo(Nationality::class, 'nationality', 'id');
    }

    public function region_rel()
    {
        return $this->belongsTo(Regions::class, 'region', 'id');
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

    public function ServicesPrice()
    {
        return $this->hasMany(LawyersServicesPrice::class, 'lawyer_id', 'id');
    }

    public function WorkTimes()
    {
        return $this->hasMany(LawyerWorkDays::class, 'lawyer_id', 'id');
    }

    public function lawyerAdvisories()
    {
        return $this->hasMany(LawyersAdvisorys::class, 'lawyer_id', 'id');
    }
    // End Relations


    //Start Mutators
    public function getPhotoAttribute()
    {
        return array_key_exists('photo', $this->attributes) && !is_null($this->attributes['photo']) ? asset('uploads/lawyers/personal_image/' . str_replace('\\', '/', $this->attributes['photo'])) : asset('uploads/person.png');
    }

    public function getLogoAttribute()
    {
        return !empty($this->attributes['logo']) || !is_null($this->attributes['logo']) ? asset('uploads/lawyers/logo/' . $this->attributes['logo']) : asset('uploads/person.png');
    }

    public function getCompanyLisencesFileAttribute()
    {
        return !empty($this->attributes['company_lisences_file']) || !is_null($this->attributes['company_lisences_file']) ? asset('uploads/lawyers/company_lisences_file/' . $this->attributes['company_lisences_file']) : null;
    }

    public function getIdFileAttribute()
    {
        return !empty($this->attributes['id_file']) || !is_null($this->attributes['id_file']) ? asset('uploads/lawyers/id_file/' . $this->attributes['id_file']) : null;
    }

    public function getLicenseFileAttribute()
    {
        return !empty($this->attributes['license_file']) || !is_null($this->attributes['license_file']) ? asset('uploads/lawyers/license_file/' . $this->attributes['license_file']) : null;
    }

    public function getCVAttribute()
    {
        return !empty($this->attributes['cv']) || !is_null($this->attributes['cv']) ? asset('uploads/lawyers/cv/' . $this->attributes['cv']) : null;
    }
    public function getDegreeCertificateAttribute()
    {
        return !empty($this->attributes['degree_certificate']) || !is_null($this->attributes['degree_certificate']) ? asset('uploads/lawyers/degree_certificate/' . $this->attributes['degree_certificate']) : null;
    }
    //End Mutators

    //Start General Functions
    public function SectionsRel()
    {
        return $this->belongsToMany(DigitalGuideCategories::class, 'lawyer_sections', 'account_details_id', 'section_id')
            ->withPivot('licence_no', 'licence_file');
    }

    public function ServicesPrices()
    {
        return $this->hasMany(LawyersServicesPrice::class, "lawyer_id", "id");
    }
    public function injectToken($token)
    {
        $this->token = $token;
    }
    //End General Functions


    //Start JWT Functions

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    //End JWT Functions

    public function fcms()
    {
        return $this->hasMany(LawyerFcmDevice::class, "lawyer_id", "id");
    }

    public function getUserTypeAttribute()
    {
        return 'lawyer';
    }
    public function auditableEvents()
    {
        return [
            'created',
            'updated',
            'deleted',
        ];
    }
    public function transformAudit(array $data): array
    {
        $data['user_type'] = $this->user_type;
        return $data;
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'account_id', 'id');
    }
    public function paymentPoints()
    {
        return $this->points()->sum('points');
    }

    public function referralCode()
    {
        return $this->hasOne(ReferralCode::class, 'account_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id')->withTrashed();
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id')->withTrashed();
    }
    public function additionalInfo()
    {
        return $this->hasOne(LawyerAdditionalInfo::class, 'account_id', 'id');
    }
    public function incrementStreak()
    {

        $lastStreak = $this->last_streak_at;
        if (is_null($lastStreak)) {
            $lastStreak = Carbon::parse($this->last_streak_at);

            \Illuminate\Support\Facades\Log::info('initializing streak');
            $this->streak = 1;
            $this->last_streak_at = now();
            $activity = Activity::find(1);
            $this->addExperience($activity->experience_points, $activity->name, $activity->notification);
            $this->save();
        } else {
            $now = now();
            $lastStreak = Carbon::parse($this->last_streak_at);
            \Illuminate\Support\Facades\Log::info($lastStreak);
            \Illuminate\Support\Facades\Log::info($now);
            // Check if the last streak was recorded more than two days ago
            if ($lastStreak < $now->subDays(2)) {
                \Illuminate\Support\Facades\Log::info('streak broke');
                // Reset the streak because more than two days have passed
                $this->streak = 1;
                $this->last_streak_at = now();
                $activity = Activity::find(1);
                $this->addExperience($activity->experience_points, $activity->name, $activity->notification);
                $this->save();
            } elseif ($lastStreak->diffInDays(now()) >= 1) {
                \Illuminate\Support\Facades\Log::info('maintaining streak');
                // Increment the streak only if a new day has started
                $streakMilestone = StreakMilestone::where('streak_milestone', $this->streak + 1)->first();
                if (!is_null($streakMilestone)) {
                    $this->addExperience($streakMilestone->milestone_xp, 'مواظبة على تسجيل الدخول لمدة ' . $streakMilestone->streak_milestone . " يوم", 'مواظبة على تسجيل الدخول لمدة ' . $streakMilestone->streak_milestone . " يوم");
                }

                $this->streak++;
                $this->last_streak_at = now();
                $activity = Activity::find(1);
                $this->addExperience($activity->experience_points, $activity->name, $activity->notification);
                $this->save();
            }
        }

        // Update the last_streak_at to now
    }
    public function addExperience($experience, $reason, $notification)
    {
        \Illuminate\Support\Facades\Log::info('logging');
        ExperienceLog::create([
            'lawyer_id' => $this->id,
            'experience' => $experience,
            'reason' => $reason,
        ]);

        \Illuminate\Support\Facades\Log::info('done');
        $notification = Notification::create([
            'title' => "تم اكتساب نقاط",
            "description" => $notification,
            "type" => "xp",
            "type_id" => null,
            // "userType" => "lawyer",
            // "lawyer_id" => $this->id,
        ]);
        $fcms = LawyerFcmDevice::where('lawyer_id', $this->id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }
        // Handle leveling up and ranking logic
        $this->applyExperience($experience);
    }

    private function applyExperience($experience)
    {
        \Illuminate\Support\Facades\Log::info('adding');
        $currentLevel = $this->level;
        $nextLevel = Level::where('level_number', $currentLevel->level_number + 1)->first();

        if ($nextLevel && $this->experience + $experience >= $nextLevel->required_experience) {
            $this->level_id = $nextLevel->id;
            $this->rank_id = Rank::where('min_level', '<=', $nextLevel->level_number)
                ->orderBy('min_level', 'desc')
                ->first()
                ->id;
        }

        $this->experience += $experience;
        $this->save();
        \Illuminate\Support\Facades\Log::info('done');
    }
}