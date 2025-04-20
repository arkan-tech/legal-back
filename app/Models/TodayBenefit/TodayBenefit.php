<?php

namespace App\Models\TodayBenefit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodayBenefit extends Model
{
    use HasFactory , SoftDeletes;
    protected $table= 'today_benefits';
    protected $guarded = [];

    public function getImageAttribute()
    {
        return !empty($this->attributes['image']) ? asset('uploads/api/today_benefit/' . str_replace('\\', '/', $this->attributes['image'])) : null;
    }
}
