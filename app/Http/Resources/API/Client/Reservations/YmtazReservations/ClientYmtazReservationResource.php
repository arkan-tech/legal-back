<?php

namespace App\Http\Resources\API\Client\Reservations\YmtazReservations;

use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesReservationResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationTypeResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Resources\API\Lawyer\LawyerWorkDaysResource;
use App\Http\Resources\API\Lawyer\LawyerWorkDaysTimesResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ClientYmtazReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service' =>$this->service->title,
            'importance' => $this->importance->title,
            'date' => $this->ymtaz_date->date,
            'time' => $this->ymtaz_time->time_from .':'.$this->ymtaz_time->time_to,
            'description' => $this->description,
            'file' => $this->file,
            'status' => $this->status,
            'replay' => $this->replay,
            'replay_file' => $this->replay_file,
            'replay_time' =>GetPmAmArabic ($this->replay_time),
            'replay_date' => GetArabicDate2($this->replay_date),
            'rate' => $this->rate,
            'comment' => $this->comment,
            'price' => $this->price,
            'transaction_complete' => $this->transaction_complete,

        ];
    }
}
