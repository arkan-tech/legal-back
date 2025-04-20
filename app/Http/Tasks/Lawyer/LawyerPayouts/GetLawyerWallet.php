<?php

namespace App\Http\Tasks\Lawyer\LawyerPayouts;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\LawyerPayments;
use App\Models\LawyerPayoutRequests;

class GetLawyerWallet extends BaseTask
{
    public function run(Request $request)
    {
        $lawyer = $this->authAccount();
        $payments = LawyerPayments::where('account_id', $lawyer->id)->get();
        $pendingAction = 0;
        $pendingTransfer = 0;
        $transferred = 0;
        $total = 0;
        foreach ($payments as $payment) {
            if ($payment->paid == 1) {
                $transferred += $payment->product->price * 0.75;
            } else {
                if ($payment->payoutRequest()->exists()) {
                    $latestPayoutRequest = $payment->payoutRequest()->latest()->first();
                    if ($latestPayoutRequest->status == 1) {
                        $pendingTransfer += $payment->product->price * 0.75;
                    } else {
                        $pendingAction += $payment->product->price * 0.75;
                    }
                } else {
                    $pendingAction += $payment->product->price * 0.75;
                }
            }
        }
        $total = $pendingAction + $pendingTransfer + $transferred;
        $wallet = [
            'pendingAction' => $pendingAction,
            'pendingTransfer' => $pendingTransfer,
            'transferred' => $transferred,
            'total' => $total
        ];
        return $this->sendResponse(true, 'Lawyer Wallet', compact('wallet'), 200);
    }
}
