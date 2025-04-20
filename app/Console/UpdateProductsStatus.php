<?php

namespace App\Console;

use Carbon\Carbon;
use App\Models\Client\ClientRequest;
use App\Models\Reservations\Reservation;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class UpdateProductsStatus
{
    private function updateStatus($model)
    {
        // if ($model->replay_status == 1) {
        //     $model->request_status = 5; // Done (Green)
        //     $model->save();
        //     return;
        // }
        // $currentDatetime = Carbon::now();
        // $requestCreationDatetime = Carbon::parse($model->created_at);
        // $timeDifference = $currentDatetime->diffInHours($requestCreationDatetime);
        // if ($model->type->need_appointment == 1) {
        //     $appointmentFrom = $model->from;
        //     $appointmentTo = $model->to;
        //     $appointmentDate = $model->day;
        //     $appointmentFrom = Carbon::parse($appointmentFrom);
        //     $appointmentTo = Carbon::parse($appointmentTo);
        //     $appointmentDate = Carbon::parse($appointmentDate);
        //     $currentDatetime = Carbon::now();
        //     $timeDifference = $currentDatetime->diffInHours($appointmentDate);
        //     if ($timeDifference < 24) {
        //         $model->request_status = 2; // waiting (Yellow)
        //     } elseif ($timeDifference < 48) {
        //         $model->request_status = 3; // Late 12 hours left till it becomes
        //     } elseif ($timeDifference >= 48) {
        //         $model->request_status = 4; // Not Done 48 hours passed (Red)
        //     }
        // } else {

        //     if ($timeDifference < 24) {
        //         $model->request_status = 2; // waiting (Yellow)
        //     } elseif ($timeDifference < 48) {
        //         $model->request_status = 3; // Late 12 hours left till it becomes 48 hours (Orange)
        //     } elseif ($timeDifference >= 48) {
        //         $model->request_status = 4; // Not Done 48 hours passed (Red)
        //     }
        // }
        // $model->save();
    }
    private function updateAdvisoryServiceStatus($model)
    {
        // if ($model->replay_status == 1) {
        //     $model->request_status = 5; // Done (Green)
        //     $model->save();
        //     return;
        // }
        // $currentDatetime = Carbon::now();
        // $requestCreationDatetime = Carbon::parse($model->created_at);
        // $timeDifference = $currentDatetime->diffInHours($requestCreationDatetime);
        // \Log::info($model->request_status . ' ' . $timeDifference);
        // if ($model->service->need_appointment == 1) {
        //     // Check if the time for the appointment has come, if so it becomes late
        //     $appointmentFrom = $model->from;
        //     $appointmentTo = $model->to;
        //     $appointmentDate = $model->day;
        //     $appointmentFrom = Carbon::parse($appointmentFrom);
        //     $appointmentTo = Carbon::parse($appointmentTo);
        //     $appointmentDate = Carbon::parse($appointmentDate);
        //     $currentDatetime = Carbon::now();
        //     $timeDifference = $currentDatetime->diffInHours($appointmentDate);
        //     if ($timeDifference < 24) {
        //         $model->request_status = 2; // waiting (Yellow)
        //     } elseif ($timeDifference < 48) {
        //         $model->request_status = 3; // Late 12 hours left till it becomes
        //     } elseif ($timeDifference >= 48) {
        //         $model->request_status = 4; // Not Done 48 hours passed (Red)
        //     }


        // } else {

        //     if ($timeDifference < 24) {
        //         $model->request_status = 2; // waiting (Yellow)
        //     } elseif ($timeDifference < 48) {
        //         $model->request_status = 3; // Late 12 hours left till it becomes 48 hours (Orange)
        //     } elseif ($timeDifference >= 48) {
        //         $model->request_status = 4; // Not Done 48 hours passed (Red)
        //     }
        // }
        // $model->save();
    }
    private function updateReservation($model)
    {
        // if ($model->reservationEnded == 1) {
        //     $model->request_status = 3;
        //     $model->save();
        //     return;
        // }
        // $appointmentFrom = $model->from;
        // $appointmentTo = $model->to;
        // $appointmentDate = $model->day;
        // $appointmentDateFrom = Carbon::createFromFormat('yyyy-mm-dd hh:mm', $appointmentDate . ' ' . $appointmentFrom);
        // $appointmentDateTo = Carbon::createFromFormat('yyyy-mm-dd hh:mm', $appointmentDate . ' ' . $appointmentFrom);

        // $appointmentFrom = Carbon::parse($appointmentFrom);
        // $appointmentTo = Carbon::parse($appointmentTo);
        // $appointmentDate = Carbon::parse($appointmentDate);
        // $currentDatetime = Carbon::now();
        // if ($currentDatetime->lessThan($appointmentDateFrom)) {
        //     return;
        // } elseif ($currentDatetime->between($appointmentDateFrom, $appointmentDateTo)) {
        //     $model->request_status = 2;
        // } elseif ($currentDatetime->greaterThan($appointmentDateTo) && $model->reservationEnded == 0) {
        //     $model->request_status = 4;
        // }

        // $model->save();
    }


    public function __invoke()
    {
        // \Log::info("Running Update Product Status");
        // $clientServiceRequests = ClientRequest::whereNot('request_status', 5)->where('transaction_complete', 1)->with('type')->get();
        // foreach ($clientServiceRequests as $serviceRequest) {
        //     $this->updateStatus($serviceRequest);
        // }
        // $lawyerServiceRequests = LawyerServicesRequest::whereNot('request_status', 5)->where('transaction_complete', 1)->with('type')->get();
        // foreach ($lawyerServiceRequests as $serviceRequest) {
        //     $this->updateStatus($serviceRequest);
        // }
        // $clientAdvisoryServiceRequests = ClientAdvisoryServicesReservations::whereNot('request_status', 5)->where('transaction_complete', 1)->with('service')->get();
        // foreach ($clientAdvisoryServiceRequests as $advisoryRequest) {
        //     $this->updateAdvisoryServiceStatus($serviceRequest);
        // }
        // $lawyerAdvisoryServiceRequests = LawyerAdvisoryServicesReservations::whereNot('request_status', 5)->where('transaction_complete', 1)->with('service')->get();
        // foreach ($lawyerAdvisoryServiceRequests as $advisoryRequest) {
        //     $this->updateAdvisoryServiceStatus($serviceRequest);
        // }
        // $reservations = Reservation::whereNot('request_status', 4)->where('transaction_complete', 1)->get();
        // foreach ($reservations as $reservation) {
        //     $this->updateReservation($reservation);
        // }
        // \Log::info("Done Updating Product Status");

    }
}
