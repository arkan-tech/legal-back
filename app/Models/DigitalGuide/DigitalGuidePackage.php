<?php

namespace App\Models\DigitalGuide;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalGuidePackage extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title', 'period', 'price','intro','rules','status','created_at', 'updated_at',
    ];

}
