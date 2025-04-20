<?php
namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebpageSponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image_id'];

    protected $table = 'webpage-sponsors';

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
