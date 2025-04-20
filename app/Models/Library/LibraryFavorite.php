<?php

namespace App\Models\Library;

use App\Models\Books;
use App\Models\Lawyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryFavorite extends Model
{
    use HasFactory,SoftDeletes;
    protected $connection = 'mysql2';

    protected $table = 'library_favorites';

    public function lawyer()
    {
        return $this->belongsTo(Lawyer\Lawyer::class, 'admin_id', 'id');
    }

    public function book()
    {
        return $this->belongsTo(\App\Models\Library\Books\Book::class, 'book_id', 'id');
    }

}
