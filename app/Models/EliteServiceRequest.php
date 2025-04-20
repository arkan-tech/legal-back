<?php

namespace App\Models;

use App\Models\Account;
use App\Models\EliteServiceCategory;
use App\Models\EliteServiceRequestFile;
use Illuminate\Database\Eloquent\Model;

class EliteServiceRequest extends Model
{
    protected $fillable = [
        'account_id',
        'elite_service_category_id',
        'description',
        'transaction_complete',
        'transaction_id',
        'status',
        'pricer_account_id',
    ];

    public function requester()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function pricer()
    {
        return $this->belongsTo(Account::class, 'pricer_account_id');
    }

    public function files()
    {
        return $this->hasMany(EliteServiceRequestFile::class, 'elite_service_request_id');
    }

    public function eliteServiceCategory()
    {
        return $this->belongsTo(EliteServiceCategory::class, 'elite_service_category_id');
    }
    // public function assignedAdvisoryCommittee(){
    //     return $this->belongsTo(Adivosory)
    // }
    public function offers()
    {
        return $this->hasOne(EliteServiceRequestsProductOffer::class, 'elite_service_request_id');
    }
}
