<?php

namespace App\Models\Degree;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Degree extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'degrees';
    protected $guarded = [];
}
