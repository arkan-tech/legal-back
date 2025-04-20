<?php

namespace App\Models\YmtazSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YmtazWorkDays extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ymtaz_available_dates';
    protected $guarded = [];
    public function times()
    {
        return $this->hasMany(YmtazWorkDayTimes::class, 'ymtaz_available_dates_id', 'id');
    }
}
