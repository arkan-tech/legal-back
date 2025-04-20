<?php

namespace App\Models\YmtazSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YmtazWorkDayTimes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ymtaz_available_dates_times';
    protected $guarded = [];

}
