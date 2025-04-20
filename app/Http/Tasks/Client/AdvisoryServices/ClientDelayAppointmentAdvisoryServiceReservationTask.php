<?php

namespace App\Http\Tasks\Client\AdvisoryServices;

use App\Http\Requests\API\Client\AdvisoryService\ClientDelayAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\AdvisoryService\ClientDelayAppointmentAdvisoryServiceReservationRequest;
use App\Http\Requests\API\Client\Reservations\ClientCreateReservationRequest;
use App\Http\Resources\API\AdvisoryServices\ClientAdvisoryServicesAppointmentResource;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\ClientReservationsResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\ClientReservations\ClientReservations;

class ClientDelayAppointmentAdvisoryServiceReservationTask extends BaseTask
{

    public function run(ClientDelayAppointmentAdvisoryServiceReservationRequest $request)
    {

        $client = $this->authClient();
        $appointment = ClientAdvisoryServicesAppointment::findOrFail($request->appointment_id);
        $advisory_services_reservation = ClientAdvisoryServicesReservations::with('service')->where('client_id', $client->id)->where('id', $appointment->client_advisory_services_reservation_id)->first();

        if ($advisory_services_reservation->reservation_status == 7) {
            return $this->sendResponse(false, 'عذراً , الاستشارة ملغية من قبل ', null, 404);
        }
        if ($advisory_services_reservation->service->need_appointment == 0) {
            return $this->sendResponse(false, 'عذراً , الاستشارة لا تحتاج الى موعد ', null, 404);
        }
        if (is_null($advisory_services_reservation)) {
            return $this->sendResponse(false, 'عذراً ,  حجز الاستشارة غير موجود ', null, 404);
        }
        if ($advisory_services_reservation->reservation_status == 3) {
            return $this->sendResponse(false, 'عذراً ,  لا يمكن تأجيل الموعد لان الموعد تم وانتهى وحالته الآن مكتمل  ', null, 422);
        }
        $advisory_services_dates_ids = AdvisoryServicesAvailableDates::where('advisory_services_id',$advisory_services_reservation->service->id)->pluck('id')->toArray();;
        $advisory_services_dates_times_ids = AdvisoryServicesAvailableDatesTimes::where('advisory_services_id',$advisory_services_reservation->service->id)
            ->where('advisory_services_available_dates_id',$request->date_id)->pluck('id')->toArray();
        if (!in_array($request->date_id,$advisory_services_dates_ids)){
            return $this->sendResponse(false, 'التاريخ غير متاح لهذه الاستشارة  ', null, 422);
        }

        if (!in_array($request->time_id,$advisory_services_dates_times_ids)){
            return $this->sendResponse(false, 'الوقت غير متاح لهذا التاريخ ', null, 422);
        }
        $date = AdvisoryServicesAvailableDates::where('advisory_services_id',$advisory_services_reservation->service->id)->where('id',$request->date_id)->first();
        $time = AdvisoryServicesAvailableDatesTimes::where('advisory_services_id',$advisory_services_reservation->service->id)
            ->where('advisory_services_available_dates_id',$request->date_id)->
            where('id',$request->time_id)
            ->first();

        $appointment->update([
            'advisory_services_date_id' => $request->date_id,
            'advisory_services_time_id' => $request->time_id,
            'date'=>$date->date,
            'time_from'=>$time->time_from,
            'time_to'=>$time->time_to,
        ]);
        $appointment = new ClientAdvisoryServicesAppointmentResource($appointment);
        return $this->sendResponse(true, 'تم تأجيل الموعد بنجاح',compact('appointment'), 200);
    }
}
