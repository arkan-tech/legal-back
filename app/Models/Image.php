<?php
namespace App\Models;

use App\Models\Section;
use App\Models\Sponsor;
use App\Models\WebpageSection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['url', 'alt_text'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function sponsors()
    {
        return $this->hasMany(Sponsor::class);
    }

    public function section()
    {
        return $this->hasOne(WebpageSection::class);
    }
}
