<?php

namespace App\Models;

use App\Models\Account;
use App\Models\Lawyer\Lawyer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LawyerPayoutRequests extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = "lawyer_payout_requests";

    public function lawyer()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
    public function payments()
    {
        return $this->belongsToMany(LawyerPayments::class, 'lawyer_payout_requests_payments', 'lawyer_payout_request_id', 'lawyer_payment_id');
    }
}
