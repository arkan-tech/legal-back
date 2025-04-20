<?php

namespace App\Models\JudicialGuide;

use Illuminate\Database\Eloquent\Model;
use App\Models\JudicialGuide\JudicialGuide;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JudicialGuideNumbers extends Model
{
    use HasFactory;

    protected $table = 'judicial_guide_numbers';

    protected $fillable = [
        'phone_code',
        'phone_number',
        'judicial_guide_id'
    ];

    public function judicialGuide()
    {
        return $this->belongsTo(JudicialGuide::class, 'judicial_guide_id');
    }

}
