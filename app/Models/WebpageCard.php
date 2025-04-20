<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebpageCard extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'webpage-cards';

    protected $fillable = [
        'name_en',
        'name_ar',
        'text_ar',
        'text_en'
    ];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        $field = "name_{$locale}";

        return $this->$field ?? $this->name_ar; // Fallback to Arabic
    }
    public function getTextAttribute()
    {
        $locale = app()->getLocale();
        $field = "text_{$locale}";

        return $this->$field ?? $this->text_ar; // Fallback to Arabic
    }
}
