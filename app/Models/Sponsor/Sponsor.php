<?php

namespace App\Models\Sponsor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'sponsors';

    protected $fillable = [
        'title','image','created_at','updated_at','link'
    ];
}
