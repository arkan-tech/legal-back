<?php

namespace App\Http\Resources\API\AdvisoryServices;

use App\Http\Resources\AccountResource;
use App\Http\Resources\AccountResourcePublic;
use App\Http\Resources\AdvisoryServicesReservationFileResource;
use App\Http\Resources\AdvisoryServicesSubCategoriesResource;
use Carbon\Carbon;
use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class AdvisoryServicesReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
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
            'description' => $this->description,
            'files' => AdvisoryServicesReservationFileResource::collection($this->files()->where('is_reply', 0)->get()),
            'request_status' => $this->request_status,
            'payment_status' => $this->paymentStatus(),
            'price' => $this->price,
            'accept_date' => GetArabicDate2($this->accept_date),
            'reservation_status' => $this->ReservationStatus(),
            'advisory_services_sub' => new AdvisoryServicesSubCategoriesResource($this->subCategoryPrice->subCategory),
            'importance' => new ClientReservationsImportanceResource($this->subCategoryPrice->importance),
            "created_at" => $this->created_at,
            'lawyer' => new AccountResourcePublic($this->lawyer),
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->day,
            // 'call_id' => $show_call_id ? $this->call_id : null,
            'call_id' => $this->call_id,
            'appointment_duration' => $time_difference,
            'reply_status' => intval($this->replay_status),
            'reply_subject' => $this->replay_subject,
            'reply_content' => $this->replay_content,
            'reply_files' => AdvisoryServicesReservationFileResource::collection($this->files()->where('is_reply', 1)->get()),
            'reply_time' => GetPmAmArabic($this->replay_time),
            'reply_date' => GetArabicDate2($this->replay_date),
        ];
    }
}
