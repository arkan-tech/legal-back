<?php
namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebpageSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content_en', 'content_ar', 'image_id', 'order'];

    protected $table = 'webpage-sections';

    protected $appends = ['content', 'image'];

    // protected $hidden = ['content_en', 'content_ar', 'image_id'];

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function getImageAttribute()
    {
        return $this->image()->first();
    }

    public function getContentAttribute()
    {
        $locale = app()->getLocale();
        $field = "content_{$locale}";
        return $this->$field ?? $this->content_ar; // Fallback to Arabic
    }
}
