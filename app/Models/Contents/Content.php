<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'contents';

    protected $fillable = [
        'Title','details','Image','second_image','section','created_at','updated_at','type'
    ];
}
