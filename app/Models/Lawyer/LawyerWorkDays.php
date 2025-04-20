<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerWorkDays extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyers_work_days';
    protected $guarded = [];
    public function times()
    {
        return $this->hasMany(LawyerWorkDayTimes::class, 'day_id', 'id');
    }
}
