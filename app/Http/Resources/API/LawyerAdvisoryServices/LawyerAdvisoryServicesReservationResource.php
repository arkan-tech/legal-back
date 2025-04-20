<?php

namespace App\Http\Resources\API\LawyerAdvisoryServices;

use Carbon\Carbon;
use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesAppointment;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservationsRates;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class LawyerAdvisoryServicesReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->service->need_appointment == 1) {
            $appointment = LawyerAdvisoryServicesAppointment::where('lawyer_advisory_services_reservation_id', $this->id)->first();
            $appointment = new LawyerAdvisoryServicesAppointmentResource($appointment);
        } else {
            $appointment = null;
        }
        $rate = LawyerAdvisoryServicesReservationsRates::where('lawyer_advisory_services_reservation_id', $this->id)->first();
        $time_difference = null;
        $show_call_id = false;
        if (!is_null($this->from)) {
            $from = Carbon::parse($this->from);
            $to = Carbon::parse($this->to);
            $current_datetime = Carbon::now();
            $time_difference = $from->diffForHumans($to, true);
            $show_call_id = $current_datetime->between($from, $to);
        }
        return [
            'id' => $this->id,
            'description' => $this->description,
            'file' => $this->file,
            'payment_status' => $this->paymentStatus(),
            'price' => $this->price,
            'request_status' => $this->reservation_status,
            'replay_status' => intval($this->replay_status),
            'replay_subject' => $this->replay_subject,
            'replay_content' => $this->replay_content,
            'replay_file' => $this->replay_file,
            'replay_time' => GetPmAmArabic($this->replay_time),
            'replay_date' => GetArabicDate2($this->replay_date),
            'accept_date' => GetArabicDate2($this->accept_date),
            'created_at' => $this->created_at,
            'reservation_status' => $this->ReservationStatus(),
            'advisory_services_id' => new AdvisoryServicesResource($this->service),
            'type' => new AdvisoryServicesTypesResource($this->type),
            'importance' => new ClientReservationsImportanceResource($this->importanceRel),
            'appointment' => $appointment,
            'lawyer' => new LawyerShortDataResource($this->lawyer),
            'rate' => !is_null($rate) ? $rate->rate : null,
            'comment' => !is_null($rate) ? $rate->comment : null,
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->day,
            'call_id' => $show_call_id ? $this->call_id : null,
            'appointment_duration' => $time_difference
        ];
    }
}
