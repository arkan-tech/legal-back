<?php

namespace App\Http\Resources\API\ClientRequest;

use Carbon\Carbon;
use JsonSerializable;
use Illuminate\Http\Request;
use App\Models\Client\ClientRequestRates;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class ClientRequestResource extends JsonResource
{
    public function referralStatus()
    {
        $referral_status = $this->referral_status;
        switch ($referral_status) {
            case 0:
                return 'انتظار';
                break;
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
        $rate = ClientRequestRates::where('client_service_request_id', $this->id)->first();
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
            'client' => new ClientDataResource($this->client),
            //            'referral_status' => $this->referralStatus(),
            'referral_status' => intval($this->referral_status),
            'lawyer' => new LawyerDataResource($this->Lawyer),
            'rate' => !is_null($rate) ? $rate->rate : null,
            'comment' => !is_null($rate) ? $rate->comment : null,
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->day,
            'call_id' => $show_call_id ? $this->call_id : null,
            'appointment_duration' => $time_difference,
        ];
    }
}
