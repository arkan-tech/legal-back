<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Lawyer\LawyerServicesAvailableDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawyerServicesAvailableDate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_services_available_dates';
    protected static function booted()
    {
        static::deleting(function ($date) {
            $times = $date->times()->delete();
        });
    }

    public function times()
    {
        return $this->hasMany(LawyerServicesAvailableDateTime::class, 'service_date_id', 'id');
    }

}
