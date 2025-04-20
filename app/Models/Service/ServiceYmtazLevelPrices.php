<?php

namespace App\Models\Service;

use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\RequestLevels\RequestLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceYmtazLevelPrices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ymtaz_service_levels_prices';
    protected $guarded = [];

    public function level()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'request_level_id', 'id');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'service_id', 'id');
    }

}
