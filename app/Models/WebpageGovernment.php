<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebpageGovernment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'webpage-governments';

    protected $fillable = [
        'name',
        'image_id',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
