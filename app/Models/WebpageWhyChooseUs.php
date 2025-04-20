<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebpageWhyChooseUs extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'webpage-why-choose-us';

    protected $fillable = [
        'text_en',
        'text_ar'
    ];

    protected $appends = ['text'];

    public function getTextAttribute()
    {
        $locale = app()->getLocale();
        $field = "text_{$locale}";

        return $this->$field ?? $this->text_ar; // Fallback to Arabic
    }
}
