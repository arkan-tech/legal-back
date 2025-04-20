<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSections extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'service_sections';
    protected $guarded = [];

}
