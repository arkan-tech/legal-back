<?php

namespace App\Models\JudicialGuide;

use Illuminate\Database\Eloquent\Model;
use App\Models\JudicialGuide\JudicialGuide;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JudicialGuideSubNumbers extends Model
{
    use HasFactory;

    protected $table = 'judicial_guide_sub_category_numbers';

    protected $fillable = [
        'phone_code',
        'phone_number',
        'judicial_guide_sub_id'
    ];

    public function judicialGuideSub()
    {
        return $this->belongsTo(JudicialGuideSubCategory::class, 'judicial_guide_sub_id');
    }

}
