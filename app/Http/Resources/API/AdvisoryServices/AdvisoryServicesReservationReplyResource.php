<?php

namespace App\Http\Resources\API\AdvisoryServices;

use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryServicesReservationReplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
		$from;
		switch($this->from){
			case 1:
				$from = "Client";
				break;
			case 2:
				$from = "Admin";
				break;
		}	
        return [
            'id' => $this->id,
			'reply' => $this->reply,
			'from' => $from,
			'attachment'=>$this->attachment,
			'created_at'=>$this->created_at
        ];
    }
}
