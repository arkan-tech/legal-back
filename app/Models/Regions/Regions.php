<?php

namespace App\Models\Regions;

use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Districts\Districts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regions extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ='regions';
    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class ,'country_id','id');
    }
    public function region(){
        return $this->belongsTo(Regions::class ,'region_id','id');
    }
    public function districts(){
        return $this->hasMany(Districts::class, 'region_id', 'id')->where('status',1);

    }
    public function cities(){
        return $this->hasMany(City::class, 'region_id', 'id')->where('status',1);

    }
}
