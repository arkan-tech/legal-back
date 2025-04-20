<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyerRates extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'lawyers_rates';
    protected $guarded = [];
}
