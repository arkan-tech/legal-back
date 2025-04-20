<?php

namespace App\Models\Library\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookRate extends Model
{
    use HasFactory , SoftDeletes;
    protected $table= 'book_rate';
    protected $guarded =[];
}
