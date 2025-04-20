<?php

namespace App\Http\Tasks\Reservations;

use App\Http\Tasks\BaseTask;
use App\Models\AppointmentsRequests;

class ReplyWithOfferTask extends BaseTask
{
    public function run($request)
    {
        $client = $this->authAccount();
        $appointmentRequest = AppointmentsRequests::where('lawyer_id', $client->id)->findOrFail($request->id);
        if ($appointmentRequest->status != 'pending') {
            return [
                'status' => false,
                'message' => 'تم الرد من قبل على هذه الخدمة',
                'data' => [],
                'code' => 400
            ];
        }
        $appointmentRequest->update(['status' => 'pending-acceptance', 'price' => $request->price]);
        return [
            'status' => true,
            'message' => 'Offer replied successfully.',
            'data' => $appointmentRequest,
            'code' => 200
        ];
    }
}
