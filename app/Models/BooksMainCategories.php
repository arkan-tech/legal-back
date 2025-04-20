<?php

namespace App\Models;

use App\Models\BooksSubCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BooksMainCategories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "books_main_categories";
    protected $fillable = [
        'name'
    ];

    protected static function booted()
    {
        static::deleting(function ($bookMainCategory) {
            $bookSubCategories = BooksSubCategories::where('main_category_id', $bookMainCategory->id)->get();
            foreach ($bookSubCategories as $bookSubCategory) {
                $bookSubCategory->delete();
            }
        });

    }
    public function subCategories()
    {
        return $this->hasMany(BooksSubCategories::class, 'main_category_id', 'id');
    }
}
