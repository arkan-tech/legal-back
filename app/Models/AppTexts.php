<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppTexts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "app_texts";
    protected $fillable = [
        "key",
        "value"
    ];
}
