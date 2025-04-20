<?php

namespace App\Http\Resources\API\LawyerServicesRequest;

use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\Client\ClientRequestRates;
use App\Models\LawyerServicesRequest\LawyerServicesRequestRates;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerServicesRequestWithLawyerRequesterResource extends JsonResource
{
    public function referralStatus()
    {
        $referral_status = $this->referral_status;
        switch ($referral_status) {

            case 1:
                return ' محالة';
                break;
            case 2:
                return ' دراسة الطلب';
                break;
            case 3:
                return '  انهاء الطلب';
                break;

        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $rate = LawyerServicesRequestRates::where('lawyer_service_request_id', $this->id)->first();

        return [
            'id' => $this->id,
            'service' => new ServicesResource($this->type),
            'priority' => new ClientReservationsImportanceResource($this->priorityRel),
            'description' => $this->description,
            'file' => $this->file,
            'price' => $this->price,
            'created_at' => $this->created_at,
            'request_status' => intval($this->request_status),
            'for_admin' => $this->forAdmin(),
            'replay_status' => $this->replay_status == 0 ? 'انتظار' : 'تم الرد',
            'replay' => $this->replay,
            'replay_file' => $this->replay_file,
            'replay_time' => GetPmAmArabic($this->replay_time),
            'replay_date' => GetArabicDate2($this->replay_date),
            'referral_status' => intval($this->referral_status),
            // 'lawyer' => new LawyerDataResource($this->Lawyer),
            'requesterLawyer' => new LawyerDataResource($this->requesterLawyer),
            'rate' => !is_null($rate) ? $rate->rate : null,
            'comment' => !is_null($rate) ? $rate->comment : null,
        ];
    }
}
