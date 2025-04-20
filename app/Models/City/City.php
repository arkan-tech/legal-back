<?php

namespace App\Models\City;

use App\Models\Country\Country;
use App\Models\Districts\Districts;
use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cities';

    protected $fillable = [
        'title', 'id', 'country_id', 'region_id', 'created_at', 'updated_at'
    ];


    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo(Regions::class, 'region_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany(Districts::class, 'city_id', 'id');
    }

}
