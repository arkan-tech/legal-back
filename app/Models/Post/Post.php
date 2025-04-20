<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'posts';

    protected $fillable = [
        'title','image','created_at','updated_at','body','slug','author','status','no_of_views','excerpt'
    ];
}
