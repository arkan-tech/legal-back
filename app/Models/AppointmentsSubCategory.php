<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AppointmentsMainCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentsSubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments_sub_category';

    protected $fillable = [
        'name',
        'description',
        'main_category_id',
    ];

    public function mainCategory()
    {
        return $this->belongsTo(AppointmentsMainCategory::class, 'main_category_id');
    }
}
