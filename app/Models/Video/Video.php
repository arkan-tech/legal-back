<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'videos';

    protected $fillable = [
        'Title', 'Description', 'AlbumID', 'created_at', 'updated_at', 'url',
    ];

    public function album()
    {
        return $this->belongsTo(Videoalbum::class, 'AlbumID', 'id');
    }
}
