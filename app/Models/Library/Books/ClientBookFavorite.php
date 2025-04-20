<?php

namespace App\Models\Library\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientBookFavorite extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'client_favorite_books';
    protected $guarded = [];
}
