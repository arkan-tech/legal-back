<?php

namespace App\Models;

use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($language) {

            $language->lawyers()->detach();
        });
    }
    public function lawyers()
    {
        return $this->belongsToMany(Lawyer::class, 'lawyer_languages');
    }
}
