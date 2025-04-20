<?php

namespace App\Models\Library\Books;

use App\Models\Library\LibraryCat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'books';

    protected $guarded = [];

    public function cat()
    {
        return $this->belongsTo(LibraryCat::class, 'CatID', 'id');
    }

    public function getImageAttribute()
    {
        return !empty($this->attributes['Image']) || !is_null($this->attributes['Image']) ? asset('uploads/books/' . str_replace('\\', '/', $this->attributes['Image'])) : asset('uploads/person.png');

    }

    public function getLinkAttribute()
    {
        return !empty($this->attributes['Link']) || !is_null($this->attributes['Link']) ? asset('uploads/books/' . str_replace('\\', '/', $this->attributes['Link'])) : asset('uploads/person.png');

    }

    public function getLinkEnAttribute()
    {
        return !empty($this->attributes['link_en']) || !is_null($this->attributes['link_en']) ? asset('uploads/books/' . str_replace('\\', '/', $this->attributes['link_en'])) : asset('uploads/person.png');

    }
}
