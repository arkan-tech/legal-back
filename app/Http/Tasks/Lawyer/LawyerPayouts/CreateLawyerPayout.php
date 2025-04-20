<?php

namespace App\Http\Tasks\Lawyer\LawyerPayouts;

use App\Http\Tasks\BaseTask;
use App\Models\LawyerPayments;
use App\Models\LawyerPayoutRequests;
use Illuminate\Http\Request;

class CreateLawyerPayout extends BaseTask
{
    public function run(Request $request)
    {
        $lawyer = $this->authAccount();

        $paymentsForPayout = LawyerPayments::where(['account_id' => $lawyer->id, 'paid' => 0])->where(function ($query) {
            $query->whereHas('payoutRequest', function ($query) {
                //TODO Check if the latest payout request status is 3
                $query->where('status', 3);
            })->orWhereDoesntHave('payoutRequest');
        })->get();

        $paymentsForPayout = $paymentsForPayout->filter(function ($model) {
            if ($model->product_type == "service") {
                return $model->product->request_status == 5 and $model->product->transaction_complete == 1;
            } else if ($model->product_type == "reservations") {
                return $model->product->reservation_ended == 1 and $model->product->transaction_complete == 1;
            } else {
                return $model->product->reservation_status == 5 and $model->product->transaction_complete == 1;
            }
        });
        if (count($paymentsForPayout) == 0) {
            return $this->sendResponse(false, 'No payments to payout', null, 400);
        }
        $payoutRequest = LawyerPayoutRequests::create([
            "lawyer_id" => $lawyer->id,
            "status" => 1,
            'comment' => ""
        ]);
        foreach ($paymentsForPayout as $payment) {
            $payoutRequest->payments()->attach($payment->id, [
                'lawyer_payout_request_id' => $payoutRequest->id,
                'lawyer_payment_id' => $payment->id,
            ]);
        }
        return $this->sendResponse(true, 'Created Payout Request', null, 201);
    }
}
