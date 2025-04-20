<?php

namespace App\Http\Resources\API\Lawyer\Reservations;

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

class LawyerReservationsLawyerResource extends JsonResource
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
            'lawyer' => new LawyerShortDataResource($this->lawyer),
            'service' => new ServicesResource($this->service),
            'importance' => new ClientReservationsImportanceResource($this->importance),
            'date' => new LawyerWorkDaysResource($this->date),
            'time' => new LawyerWorkDaysTimesResource($this->time),
            'description' => $this->description,
            'file' => $this->file,
            'price' => $this->price,
            'transaction_complete' => $this->transaction_complete,
            'complete_status' => $this->complete_status,
            'replay' => $this->replay,
            'replay_time' =>GetPmAmArabic ($this->replay_time),
            'replay_date' =>GetArabicDate2( $this->replay_date),
            'replay_file' => $this->replay_file,
            'comment' => $this->comment,
            'rate' => $this->rate,
        ];
    }
}
