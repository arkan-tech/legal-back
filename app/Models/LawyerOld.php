<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerOld extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "lawyers_old";
    protected $guarded = [];

    public function SectionsRel()
    {
        return $this->belongsToMany(DigitalGuideCategories::class, 'lawyer_sections_old', 'lawyer_id', 'section_id')
            ->withPivot('licence_no', 'licence_file');

    }

}
