<?php

namespace App\Models\Service;

use Carbon\Carbon;
use App\Models\Rank;
use App\Models\Level;
use App\Models\Point;
use App\Models\Activity;
use App\Models\UserRank;
use App\Models\City\City;
use Illuminate\Support\Str;
use App\Models\Notification;
use App\Models\ReferralCode;
use App\Models\ExperienceLog;
use OwenIt\Auditing\Auditable;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\StreakMilestone;
use App\Models\Country\Nationality;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use Illuminate\Database\Eloquent\Model;
use Nagy\LaravelRating\Traits\Rateable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use LevelUp\Experience\Concerns\HasStreaks;
use Illuminate\Database\Eloquent\SoftDeletes;
use LevelUp\Experience\Concerns\GiveExperience;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

//class ServiceUser extends  Authenticatable
class ServiceUser extends Authenticatable implements JWTSubject, AuditableContract
{
    use Rateable, Notifiable, HasFactory, SoftDeletes, Auditable;

    protected $table = 'service_users';
    protected $guarded = [];
    protected $hidden = ['password', 'remember_token'];
    protected $keyType = 'string';
    public $incrementing = false;
    protected $appends = ['token'];

    public $token;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
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



    public function fcms()
    {
        return $this->hasMany(ClientFcmDevice::class, 'client_id', 'id');
    }
    public function injectToken($token)
    {
       return $this->token = $token;
        // return $this;
    }
    public function getTokenAttribute()
{
    return $this->token;
}

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
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'myname' => $this->myname,
            'image' => $this->image,
            'mobil' => $this->mobil,
            'nationality_id' => $this->nationality_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'email' => $this->email,
            'type' => $this->type,
            'active' => $this->active,
            'activation_type' => $this->activation_type,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'region_id' => $this->region_id,
            'phone_code' => $this->phone_code,
            'gender' => $this->gender,
            'accepted' => $this->accepted,
            'level_id' => $this->level_id,
            'rank_id' => $this->rank_id,
            'streak' => $this->streak,
        ];
    
    }

    public function getUserTypeAttribute()
    {
        return 'client';
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
            $lastStreak = Carbon::parse($this->last_streak_at);
            $now = now();
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
        ExperienceLog::create([
            'account_id' => $this->id,
            'experience' => $experience,
            'reason' => $reason,
        ]);

        $notification = Notification::create([
            'title' => "تم اكتساب نقاط",
            "description" => $notification,
            "type" => "xp",
            "type_id" => null,
            "userType" => "client",
            "service_user_id" => $this->id,
        ]);
        $fcms = ClientFcmDevice::where('client_id', $this->id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        // Handle leveling up and ranking logic
        $this->applyExperience($experience);
    }

    private function applyExperience($experience)
    {
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
    }
}