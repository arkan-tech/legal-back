<?php

namespace App\Models;

use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceUserOld extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "service_users_old";
    protected $guarded = [];
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');

    }
    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'id');
    }

}
