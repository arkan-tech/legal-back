<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BookGuideBook;

class BookGuide extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'book_guide';
    protected $fillable = [
        'name_en',
        'name_ar',
        'category_id',
        'word_file_en',
        'word_file_ar',
        'pdf_file_en',
        'pdf_file_ar',
        'about_ar',
        'about_en',
        'published_at',
        'released_at',
        'status',
        'number_of_chapters',
        'release_tool_ar',
        'release_tool_en',
    ];
    public $timestamps = false;
    protected $hidden = [
        'name_en',
        'name_ar',
        'word_file_en',
        'word_file_ar',
        'pdf_file_en',
        'pdf_file_ar',
        'about_ar',
        'about_en',
        'release_tool_ar',
        'release_tool_en',
    ];

    protected $appends = [
        'name',
        'word_file',
        'pdf_file',
        'about',
        'release_tool',
    ];

    protected static function booted()
    {
        static::deleting(function ($bookGuide) {
            $bookGuide->books()->delete();
        });
    }

    public function books()
    {
        return $this->hasMany(BookGuideBook::class, 'book_guide_id', 'id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(BookGuideMainCategory::class, 'category_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(BookGuideCategory::class, 'category_id');
    }

    public function sections()
    {
        return $this->hasMany(BookGuideSection::class, 'book_guide_id');
    }

    public function getNameAttribute()
    {
        return $this->getName(app()->getLocale());
    }

    public function getWordFileAttribute()
    {
        return $this->getWordFile(app()->getLocale());
    }

    public function getPdfFileAttribute()
    {
        return $this->getPdfFile(app()->getLocale());
    }

    public function getAboutAttribute()
    {
        return $this->getAbout(app()->getLocale());
    }

    public function getReleaseToolAttribute()
    {
        return $this->getReleaseTool(app()->getLocale());
    }

    public function getName($locale = 'en')
    {
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    public function getWordFile($locale = 'en')
    {
        return $locale === 'ar' ? $this->word_file_ar : $this->word_file_en;
    }

    public function getPdfFile($locale = 'en')
    {
        return $locale === 'ar' ? $this->pdf_file_ar : $this->pdf_file_en;
    }

    public function getAbout($locale = 'en')
    {
        return $locale === 'ar' ? $this->about_ar : $this->about_en;
    }

    public function getReleaseTool($locale = 'en')
    {
        return $locale === 'ar' ? $this->release_tool_ar : $this->release_tool_en;
    }

    public static function getMainCategories()
    {
        return BookGuideMainCategory::with('bookGuides')->get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'guides' => $category->bookGuides->map(function ($guide) {
                    return [
                        'id' => $guide->id,
                        'name' => $guide->name
                    ];
                })
            ];
        });
    }

    public static function getBooks()
    {
        return BookGuideBook::with(['bookGuide', 'bookGuide.mainCategory'])
            ->get()
            ->map(function ($book) {
                return [
                    'id' => $book->id,
                    'name' => $book->name,
                    'guide_id' => $book->book_guide_id,
                    'guide_name' => $book->bookGuide ? $book->bookGuide->name : '',
                    'category_id' => $book->bookGuide && $book->bookGuide->mainCategory ? $book->bookGuide->mainCategory->id : null,
                    'category_name' => $book->bookGuide && $book->bookGuide->mainCategory ? $book->bookGuide->mainCategory->name : ''
                ];
            });
    }

    public function getWordFileArAttribute()
    {
        return !empty($this->attributes['word_file_ar']) ? asset('uploads/book_guide/' . str_replace('\\', '/', $this->attributes['word_file_ar'])) : null;
    }

    public function getWordFileEnAttribute()
    {
        return !empty($this->attributes['word_file_en']) ? asset('uploads/book_guide/' . str_replace('\\', '/', $this->attributes['word_file_en'])) : null;
    }

    public function getPdfFileArAttribute()
    {
        return !empty($this->attributes['pdf_file_ar']) ? asset('uploads/book_guide/' . str_replace('\\', '/', $this->attributes['pdf_file_ar'])) : null;
    }

    public function getPdfFileEnAttribute()
    {
        return !empty($this->attributes['pdf_file_en']) ? asset('uploads/book_guide/' . str_replace('\\', '/', $this->attributes['pdf_file_en'])) : null;
    }
}
