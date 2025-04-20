<?php

namespace App\Models;

use App\Models\LawGuide;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawGuideMainCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'law_guide_main_category';
    protected $fillable = [
        'name',
        'name_en',
        'order'
    ];

    protected static function booted()
    {
        static::deleting(function ($lawGuideMainCategory) {
            $lawGuideMainCategory = LawGuide::where('category_id', $lawGuideMainCategory->id)->get();
            foreach ($lawGuideMainCategory as $lawGuide) {
                $lawGuide->delete();
            }
        });

    }
    public function lawGuides()
    {
        return $this->hasMany(LawGuide::class, 'category_id', 'id');
    }
}
