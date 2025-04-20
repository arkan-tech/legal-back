<?php

namespace App\Models;

use App\Models\Books;
use App\Models\BooksMainCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BooksSubCategories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "books_sub_categories";
    protected $fillable = [
        'name',
        'main_category_id'
    ];

    protected static function booted()
    {
        static::deleting(function ($bookSubCategory) {
            $bookSubCategory->books->delete();
        });

    }
    public function books()
    {
        return $this->hasMany(Books::class, 'sub_category_id', 'id');
    }
    public function mainCategory()
    {
        return $this->belongsTo(BooksMainCategories::class, 'main_category_id', 'id');
    }
}
