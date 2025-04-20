<?php

namespace App\Models;

use App\Models\AppointmentsSubPrices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppointmentsMainCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments_main_category';

    protected $fillable = [
        'name',
        'description',
        'min_price',
        'max_price',
        'is_hidden'
    ];

    public function prices()
    {
        return $this->hasMany(AppointmentsSubPrices::class, 'main_category_id');
    }
}
