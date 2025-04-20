<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Devices\ClientFcmDevice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gamification extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'gamification_info';
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
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id')->withTrashed();
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class, 'rank_id')->withTrashed();
    }
    public function points()
    {
        return $this->hasMany(Point::class, 'account_id', 'id');
    }

    public function paymentPoints()
    {
        return $this->points()->sum('points');
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
            // Check if the last streak was recorded more than two days ago
            if ($lastStreak < $now->subDays(2)) {
                // Reset the streak because more than two days have passed
                $this->streak = 1;
                $this->last_streak_at = now();
                $activity = Activity::find(1);
                $this->addExperience($activity->experience_points, $activity->name, $activity->notification);
                $this->save();
            } elseif ($lastStreak->diffInDays(now()) >= 1) {
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
            'account_id' => $this->account->id,
            'experience' => $experience,
            'reason' => $reason,
        ]);

        $notification = Notification::create([
            'title' => "تم اكتساب نقاط",
            "description" => $notification,
            "type" => "xp",
            "type_id" => null,
            "account_id" => $this->account->id,
        ]);
        $fcms = AccountFcm::where('account_id', $this->account->id)->pluck('fcm_token')->toArray();
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