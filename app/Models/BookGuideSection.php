<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookGuideSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'section_text_ar',
        'section_text_en',
        'changes_ar',
        'changes_en',
        'book_guide_id',
    ];

    protected $hidden = [
        'name_en',
        'name_ar',
        'section_text_ar',
        'section_text_en',
        'changes_ar',
        'changes_en',
    ];

    protected $appends = [
        'name',
        'section_text',
        'changes',
    ];

    public function bookGuide()
    {
        return $this->belongsTo(BookGuide::class, 'book_guide_id');
    }

    public function getNameAttribute()
    {
        return $this->getName(app()->getLocale());
    }

    public function getSectionTextAttribute()
    {
        return $this->getSectionText(app()->getLocale());
    }

    public function getChangesAttribute()
    {
        return $this->getChanges(app()->getLocale());
    }

    public function getName($locale = 'en')
    {
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getSectionText($locale = 'en')
    {
        return $locale === 'ar' ? $this->section_text_ar : $this->section_text_en;
    }

    public function getChanges($locale = 'en')
    {
        return $locale === 'ar' ? $this->changes_ar : $this->changes_en;
    }
}
