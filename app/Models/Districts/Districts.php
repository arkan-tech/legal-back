<?php

namespace App\Models\Districts;

use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Districts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'districts';
    protected $guarded = [];

    public function City()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }
    public function region()
    {
        return $this->hasOne(Regions::class, 'id', 'region_id');
    }
    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
