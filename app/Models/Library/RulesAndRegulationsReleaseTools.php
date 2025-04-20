<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RulesAndRegulationsReleaseTools extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rules_regulations_release_tools';

    protected $guarded = [];


    //     Start Relations //

    public function MainRule()
    {
        return $this->belongsTo(RulesAndRegulations::class, 'rules_regulation_id', 'id');
    }


    //     End Relations //


}
