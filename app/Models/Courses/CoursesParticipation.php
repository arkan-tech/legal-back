<?php

namespace App\Models\Courses;

use App\Models\Service\ServiceUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursesParticipation extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id', 'course_id', 'status', 'price', 'created_at', 'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(ServiceUser::class, 'user_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    // public function priority()
    // {
    //     if ($this->priority == 1) {
    //         return "عاجل جدا";
    //     } elseif ($this->priority == 2) {
    //         return "مرتبط بموعد";
    //     } elseif ($this->priority == 3) {
    //         return "أخرى";
    //     }
    // }
}
