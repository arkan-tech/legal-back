<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JudicialBlogsReleaseTools extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'judicial_blogs_release_tools';

    protected $guarded = [];


    //     Start Relations //

    public function MainRule()
    {
        return $this->belongsTo(JudicialBlogs::class, 'judicial_blog_id', 'id');
    }


    //     End Relations //


}
