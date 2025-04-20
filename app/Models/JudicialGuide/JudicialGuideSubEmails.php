<?php

namespace App\Models\JudicialGuide;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JudicialGuideSubEmails extends Model
{
    use HasFactory;

    protected $table = 'judicial_guide_sub_category_emails';

    protected $fillable = [
        'email',
        'judicial_guide_sub_id'
    ];


}
