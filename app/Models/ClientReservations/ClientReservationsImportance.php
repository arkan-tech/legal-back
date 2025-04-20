<?php

namespace App\Models\ClientReservations;

use App\Models\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Service\ServiceYmtazLevelPrices;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientReservationsImportance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'client_reservations_importance';
    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($importance) {
            $advisoryServicesPrices = AdvisoryServicesPrices::where('client_reservations_importance_id', $importance->id)->get();
            foreach ($advisoryServicesPrices as $advisoryServicesPrice) {
                $advisoryServicesPrice->delete();
            }
            $ymtazServicePrices = ServiceYmtazLevelPrices::where('request_level_id', $importance->id)->get();
            foreach ($ymtazServicePrices as $ymtazServicePrice) {
                $ymtazServicePrice->delete();
            }
            $lawyerServicePrices = LawyersServicesPrice::where('client_reservations_importance_id', $importance->id)->get();
            foreach ($lawyerServicePrices as $lawyerServicePrice) {
                $lawyerServicePrice->delete();
            }
        });
    }
    public function advisoryServices()
    {
        return $this->belongsToMany(AdvisoryServices::class, 'advisory_services_prices', 'client_reservations_importance_id');
    }
}
