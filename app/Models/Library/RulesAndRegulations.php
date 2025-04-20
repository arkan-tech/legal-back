<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RulesAndRegulations extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rules_regulations';

    protected $guarded = [];


    //     Start Relations //

    public function MainCategory()
    {
        return $this->belongsTo(LibraryCat::class, 'category_id', 'id');
    }

    public function SubCategory()
    {
        return $this->belongsTo(LibraryCat::class, 'sub_category_id', 'id');
    }

    public function ReleasTools()
    {
        return $this->hasMany(RulesAndRegulationsReleaseTools::class, 'rules_regulation_id', 'id');
    }


    //     End Relations //
//---------------------------------------------------------------------------------------------------------------------------------//
    //     Start Mutator //

    public function getWorldFileAttribute()
    {
        return !empty($this->attributes['world_file']) || !is_null($this->attributes['world_file']) ? asset('uploads/library/rules_regulations/world/' . str_replace('\\', '/', $this->attributes['world_file'])) : null;

    }

    public function getPdfFileAttribute()
    {
        return !empty($this->attributes['pdf_file']) || !is_null($this->attributes['pdf_file']) ? asset('uploads/library/rules_regulations/pdf/' . str_replace('\\', '/', $this->attributes['pdf_file'])) : null;

    }
    //     End Mutator //

}
