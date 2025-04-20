<?php

namespace App\Models\JusticeGuide;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JusticeGuide extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'justiceguides';

    protected $fillable = [
        'parent_id','image','created_at','updated_at','title','category_id','latitude','longitude','email','phone'
    ];

}
