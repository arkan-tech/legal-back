<?php

namespace App\Models;

use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EliteServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function advisoryCommittees()
    {
        return $this->belongsToMany(AdvisoryCommittee::class, 'elite_service_categories_advisory_comittees', 'elite_service_category_id', 'advisory_committee_id');
    }
}
