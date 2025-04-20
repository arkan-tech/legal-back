<?php

namespace App\Models\FunctionalCases;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FunctionalCases extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = 'functional_cases';
    protected $guarded = [];

}
