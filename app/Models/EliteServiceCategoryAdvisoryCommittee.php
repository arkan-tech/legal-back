<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EliteServiceCategoryAdvisoryCommittee extends Model
{
    use HasFactory, SoftDeletes;

    // Specify table name since it does not follow the convention.
    protected $table = 'elite_service_categories_advisory_comittees';

    protected $fillable = ['elite_service_category_id', 'advisory_committee_id'];
}
