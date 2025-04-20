<?php

namespace App\Models\JusticeGuideCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use TCG\Voyager\Traits\Translatable;

class JusticeGuideCategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'justice_guide_categories';

    protected $fillable = ['slug', 'name'];
    public function parentId()
    {
        return $this->belongsTo(self::class);
    }

}
