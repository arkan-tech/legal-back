<?php

namespace App\Models\Lawyer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawyersAdvisorys extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'lawyers_advisorys';
    protected $guarded = [];


}
