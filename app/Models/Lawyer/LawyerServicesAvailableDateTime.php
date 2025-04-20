<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawyerServicesAvailableDateTime extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lawyer_services_available_dates_times';

}
