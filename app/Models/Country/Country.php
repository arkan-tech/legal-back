<?php

namespace App\Models\Country;

use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';
    protected $fillable = ['name', 'code', 'phone_code', 'status'];

    public function regions()
    {
        return $this->hasMany(Regions::class, 'country_id', 'id')->where('status',1);
    }

}
