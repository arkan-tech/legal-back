<?php

namespace App\Models;

use App\Models\BooksSubCategories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Books extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "books";
    protected $fillable = [
        'name',
        'sub_category_id',
        'author_name',
        'file_id'
    ];

    protected $appends = ['file'];
    public function subCategory()
    {
        return $this->belongsTo(BooksSubCategories::class, 'sub_category_id', 'id');
    }

    public function getFileAttribute()
    {
        return !empty($this->attributes['file_id']) || !is_null($this->attributes['file_id']) ? asset('uploads/books/' . $this->attributes['file_id']) : null;
    }
}
