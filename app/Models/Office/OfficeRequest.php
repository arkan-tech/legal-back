<?php

namespace App\Models\Office;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OfficeRequest extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'office_requests';
}
