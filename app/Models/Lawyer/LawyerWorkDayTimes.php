<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerWorkDayTimes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyers_work_days_times';
    protected $guarded = [];

}
