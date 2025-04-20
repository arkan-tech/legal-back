<?php

namespace App\Models;

use App\Models\LawGuideLaw;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawGuide extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'name_en',
        'category_id',
        'order',
        'word_file_ar',
        'word_file_en',
        'pdf_file_ar',
        'pdf_file_en',
        'released_at',
        'published_at',
        'about',
        'about_en',
        'status',
        'release_tool',
        'release_tool_en',
        'number_of_chapters'
    ];

    protected static function booted()
    {
        static::deleting(function ($lawGuide) {
            $lawGuide->laws()->delete();
            $lawGuide->relatedLawGuides()->delete();
            $lawGuide->relatedToLawGuides()->delete();
        });
    }
    protected $table = "law_guide";

    public function laws()
    {
        return $this->hasMany(LawGuideLaw::class, 'law_guide_id', 'id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(LawGuideMainCategory::class, 'category_id', 'id');
    }

    public function relatedLawGuides()
    {
        return $this->belongsToMany(LawGuide::class, 'law_guide_relations', 'source_law_guide_id', 'related_law_guide_id')
            ->withTimestamps();
    }

    public function relatedToLawGuides()
    {
        return $this->belongsToMany(LawGuide::class, 'law_guide_relations', 'related_law_guide_id', 'source_law_guide_id')
            ->withTimestamps();
    }

    public function getAllRelatedLawGuides()
    {
        return $this->relatedLawGuides->merge($this->relatedToLawGuides);
    }

    public static function getMainCategories()
    {
        return LawGuideMainCategory::with('lawGuides')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'guides' => $category->lawGuides->map(function ($guide) {
                    return [
                        'id' => $guide->id,
                        'name' => $guide->name
                    ];
                })
            ];
        });
    }

    public static function getLaws()
    {
        return LawGuideLaw::with(['lawGuide', 'lawGuide.mainCategory'])
            ->get()
            ->map(function ($law) {
                return [
                    'id' => $law->id,
                    'name' => $law->name,
                    'guide_id' => $law->law_guide_id,
                    'guide_name' => $law->lawGuide ? $law->lawGuide->name : '',
                    'category_id' => $law->lawGuide && $law->lawGuide->mainCategory ? $law->lawGuide->mainCategory->id : null,
                    'category_name' => $law->lawGuide && $law->lawGuide->mainCategory ? $law->lawGuide->mainCategory->name : ''
                ];
            });
    }

    public function getWordFileArAttribute()
    {
        return !empty($this->attributes['word_file_ar']) ? asset('uploads/law_guide/' . str_replace('\\', '/', $this->attributes['word_file_ar'])) : null;
    }
    public function getWordFileEnAttribute()
    {
        return !empty($this->attributes['word_file_en']) ? asset('uploads/law_guide/' . str_replace('\\', '/', $this->attributes['word_file_en'])) : null;
    }
    public function getPdfFileArAttribute()
    {
        return !empty($this->attributes['pdf_file_ar']) ? asset('uploads/law_guide/' . str_replace('\\', '/', $this->attributes['pdf_file_ar'])) : null;
    }
    public function getPdfFileEnAttribute()
    {
        return !empty($this->attributes['pdf_file_en']) ? asset('uploads/law_guide/' . str_replace('\\', '/', $this->attributes['pdf_file_en'])) : null;
    }
}
