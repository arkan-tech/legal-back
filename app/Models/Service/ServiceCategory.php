<?php

namespace App\Models\Service;

use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'services_categories';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($serviceCategory) {
            $services = Service::where('category_id', $serviceCategory->id)->get();
            foreach ($services as $service) {
                $service->delete();
            }
        });
    }


    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}
