<?php

namespace App\Models\Lawyer;

use App\Models\Account;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Lawyer\LawyerServicesAvailableDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ClientReservations\ClientReservationsImportance;

class LawyersServicesPrice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'price',
        'lawyer_id',
        'service_id',
        'created_at',
        'updated_at'
    ];
    protected static function booted()
    {
        static::deleting(function ($lawyerPrice) {
            $dates = LawyerServicesAvailableDate::where('service_id', $lawyerPrice->id)->get();
            foreach ($dates as $date) {
                $date->delete();
            }
        });
    }


    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function service()
    {
        // return $this->belongsTo(ServicesType::class, 'service_id', 'id');

        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function importance()
    {
        return $this->belongsTo(ClientReservationsImportance::class, 'client_reservations_importance_id', 'id');
    }

    public function dates()
    {
        return $this->hasMany(LawyerServicesAvailableDate::class, 'service_id', 'id');
    }
}
