<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ServicesType extends Model
{
    use HasFactory,SoftDeletes;

    protected $table  ='services_types';
    protected $guarded = [];

}
