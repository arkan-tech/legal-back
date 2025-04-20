<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EliteServicePricingCommittee extends Model
{
    // Specify table name. Note: the migration creates 'elite_service_pricing_comittee'
    protected $table = 'elite_service_pricing_comittee';

    // Define fillable attributes.
    protected $fillable = ['account_id', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function getStatistics()
    {
        $totalRequests = EliteServiceRequest::where('pricer_account_id', $this->account_id)->count();
        $pendingRequests = EliteServiceRequest::where('pricer_account_id', $this->account_id)
            ->whereNull('transaction_complete')
            ->count();
        $completedRequests = EliteServiceRequest::where('pricer_account_id', $this->account_id)
            ->whereNotNull('transaction_complete')
            ->count();

        return [
            'total' => $totalRequests,
            'pending' => $pendingRequests,
            'completed' => $completedRequests
        ];
    }
}
