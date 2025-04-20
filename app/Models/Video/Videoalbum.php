<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Videoalbum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'videoalbums';

    protected $fillable = [
        'title', 'Image', 'type', 'created_at', 'updated_at'
    ];


}
