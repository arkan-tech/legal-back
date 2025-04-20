<?php

namespace App\Models\Specialty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccurateSpecialty extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accurate_specialty';
    protected $guarded = [];


}
