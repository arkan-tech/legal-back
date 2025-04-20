<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Lawyer\LawyerBasicDataResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Http\Resources\AdvisoryServicesReservationFileResource;

class ServicesReservationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
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
            'account' => new AccountResource($this->account),
            'service' => new ServicesResource($this->type),
            'priority' => new ClientReservationsImportanceResource($this->priorityRel),
            'description' => $this->description,
            'files' => AdvisoryServicesReservationFileResource::collection($this->files()->where('is_reply', false)->get()),
            'price' => $this->price,
            'created_at' => $this->created_at,
            'request_status' => intval($this->request_status),
            'for_admin' => $this->forAdmin(),
            'replay_status' => $this->replay_status == 0 ? 'انتظار' : 'تم الرد',
            'replay' => $this->replay,
            'replay_files' => AdvisoryServicesReservationFileResource::collection($this->files()->where('is_reply', true)->get()),
            'replay_time' => GetPmAmArabic($this->replay_time),
            'replay_date' => GetArabicDate2($this->replay_date),
            'referral_status' => intval($this->referral_status),
            'lawyer' => new AccountResourcePublic($this->lawyer),
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->day,
            'call_id' => $show_call_id ? $this->call_id : null,
            'appointment_duration' => $time_difference
        ];
    }
}
