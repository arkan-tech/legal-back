<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Lawyer\Lawyer;
use App\Models\Client\ClientRequest;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservations\Reservation;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class LawyerPayments extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    protected $table = "lawyer_payments";

    public function Lawyer()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function payoutRequest()
    {
        return $this->belongsToMany(LawyerPayoutRequests::class, 'lawyer_payout_requests_payments', 'lawyer_payment_id', 'lawyer_payout_request_id');

    }

    // Lawyer relationships
    public function Service()
    {
        return $this->belongsTo(ServicesReservations::class, 'product_id');
    }

    public function AdvisoryService()
    {
        return $this->belongsTo(AdvisoryServicesReservations::class, 'product_id');
    }

    public function Reservation()
    {
        return $this->belongsTo(Reservation::class, 'product_id');
    }

    // Method to get the appropriate product relationship
    public function product()
    {
        return $this->getProductRelation();

    }

    private function getProductRelation()
    {
        switch ($this->product_type) {
            case 'service':
                return $this->Service();
            case 'advisory_services':
                return $this->AdvisoryService();
            case 'reservation':
                return $this->Reservation();
            default:
                return $this->belongsTo(ServicesReservations::class, 'product_id')->whereRaw("1 = 0");

        }
    }

}
