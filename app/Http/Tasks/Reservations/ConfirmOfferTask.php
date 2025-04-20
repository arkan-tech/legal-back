<?php

namespace App\Http\Tasks\Reservations;

use App\Models\AppointmentsRequests;

class ConfirmOfferTask
{
    public function run($request)
    {
        $appointmentRequest = AppointmentsRequests::findOrFail($request->id);
        $status = $request->status;
        if ($status == 'rejected') {
            $appointmentRequest->update(['status' => 'rejected']);
            return [
                'status' => true,
                'message' => 'Offer rejected successfully.',
                'data' => $appointmentRequest,
                'code' => 200
            ];
        }
        $appointmentRequest->update(['status' => 'accepted']);
        // Create appointment reservation
        $appointmentReservation = new \App\Models\AppointmentsReservations();
        $appointmentReservation->appointment_sub_id = $appointmentRequest->appointment_sub_id;
        $appointmentReservation->importance_id = $appointmentRequest->importance_id;
        $appointmentReservation->account_id = $appointmentRequest->account_id;
        $appointmentReservation->lawyer_id = $appointmentRequest->lawyer_id;
        $appointmentReservation->price = $appointmentRequest->price;
        $appointmentReservation->description = $appointmentRequest->description;
        $appointmentReservation->status = 'pending';
        $appointmentReservation->save();
        $appointmentRequest->update(['reservation_id' => $appointmentReservation->id]);
        $appointmentRequest->files()->update(
            [
                'appointment_reservation_id' => $appointmentReservation->id
            ]
        );
        AppointmentsRequests::where('appointment_sub_id', $appointmentRequest->appointment_sub_id)
            ->where('importance_id', $appointmentRequest->importance_id)
            ->where('account_id', $appointmentRequest->account_id)
            ->whereNot('id', $appointmentRequest->id)
            ->update(['status' => 'rejected']);
        return [
            'status' => true,
            'message' => 'Offer confirmed successfully.',
            'data' => $appointmentRequest,
            'code' => 200
        ];
    }
}
