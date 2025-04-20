<?php

namespace App\Http\Tasks\Lawyer\LawyerPayouts;

use App\Http\Tasks\BaseTask;
use App\Models\LawyerPayoutRequests;
use Illuminate\Http\Request;

class GetLawyerPayouts extends BaseTask
{
    public function run(Request $request)
    {
        $lawyer = $this->authAccount();

        $payoutRequests = LawyerPayoutRequests::where('lawyer_id', $lawyer->id)->with(
            'payments'
        )->get();
        $payoutRequests = $payoutRequests->each(function ($payoutRequest) {
            $payoutRequest->payments->each(function ($payment) {
                $payment->setRelation('product', $payment->product);
            });
        });
        return $this->sendResponse(true, 'Lawyer Payout Requests', compact('payoutRequests'), 200);
    }
}
