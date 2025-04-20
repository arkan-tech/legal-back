<?php

namespace App\Models\DigitalGuide;

use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerSections;
use App\Models\Service\ServiceSections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DigitalGuideCategories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'digital_guide_sections';

    protected $fillable = [
        'title',
        'image',
        'need_license',
        'status'
    ];

    protected static function booted()
    {
        static::deleting(function ($digitalGuideCategory) {
            ServiceSections::where('section_id', $digitalGuideCategory->id)->delete();
            $advisoryServicesTypes = AdvisoryServicesTypes::whereHas('lawyerSections', function ($query) use ($digitalGuideCategory) {
                $query->where('lawyer_section_id', $digitalGuideCategory->id);
            })->with('lawyerSections')->get();
            foreach ($advisoryServicesTypes as $advisoryServiceType) {
                $advisoryServiceType->lawyerSections()->detach();
            }
            LawyerSections::where('section_id', $digitalGuideCategory->id)->delete();
        });
    }
    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) ? asset('uploads/DigitalGuideCategories/' . str_replace('\\', '/', $this->attributes['image'])) : asset('uploads/person.png');
    }
}
