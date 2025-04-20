<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawGuideLaw extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "law_guide_laws";
    protected $fillable = [
        'law_guide_id',
        "name",
        'name_en',
        "law",
        'law_en',
        'changes',
        'changes_en'
    ];

    protected static function booted()
    {
        static::deleting(function ($law) {
            $law->relatedLaws()->delete();
            $law->relatedToLaws()->delete();
        });
    }

    public function LawGuide()
    {
        return $this->belongsTo(LawGuide::class, 'law_guide_id');
    }

    // public function getNameAttribute()
    // {
    //     return app()->getLocale() == 'ar' ? $this->attributes['name'] : ($this->attributes['name_en'] ?? $this->attributes['name']);
    // }

    // public function getLawAttribute()
    // {
    //     return app()->getLocale() == 'ar' ? $this->attributes['law'] : ($this->attributes['law_en'] ?? $this->attributes['law']);
    // }

    // public function getChangesAttribute()
    // {
    //     return app()->getLocale() == 'ar' ? $this->attributes['changes'] : ($this->attributes['changes_en'] ?? $this->attributes['changes']);
    // }

    // Add relationships for related laws
    public function relatedLaws()
    {
        return $this->belongsToMany(LawGuideLaw::class, 'law_guide_law_relations', 'source_law_id', 'related_law_id')
            ->withTimestamps();
    }

    public function relatedToLaws()
    {
        return $this->belongsToMany(LawGuideLaw::class, 'law_guide_law_relations', 'related_law_id', 'source_law_id')
            ->withTimestamps();
    }

    // Helper method to get all related laws (both directions)
    public function getAllRelatedLaws()
    {
        return $this->relatedLaws->merge($this->relatedToLaws);
    }
}
