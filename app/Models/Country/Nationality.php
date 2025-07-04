<?php

namespace App\Models\Country;

use App\Models\Regions\Regions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nationality extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nationalities';
    protected $guarded = [];


}
