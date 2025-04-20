<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banners extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "banners_api";
    protected $fillable = [
        "image",
        "expires_at"
    ];

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) || !is_null($this->attributes['image']) ? asset('uploads/banners/' . $this->attributes['image']) : asset('uploads/person.png');
    }
}
