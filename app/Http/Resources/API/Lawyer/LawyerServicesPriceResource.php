<?php

namespace App\Http\Resources\API\Lawyer;

use JsonSerializable;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;

class LawyerServicesPriceResource extends JsonResource
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
            'service_id' => $this->id,
            "category_id" => $this->category_id,
            "request_level_id" => $this->request_level_id,
            "title" => $this->title,
            "image" => $this->image,
            "intro" => $this->intro,
            "details" => $this->details,
            "slug" => $this->slug,
            "section_id" => $this->section_id,
            "min_price" => $this->min_price,
            "max_price" => $this->max_price,
            "sections" => $this->sections,
            "ymtaz_price" => $this->ymtaz_price,
            "status" => $this->status,
            "need_appointment" => 1,
            'lawyer_prices'=> $this->lawyerPrices->map(function ($data){
                return [
                    'price' => $data->price,
                    'importance' => new ClientReservationsImportanceResource($data->importance),
                    // 'dates' => $data->dates->map(function ($date) {
                    //     return [
                    //         'date' => $date->date,
                    //         'times' => $date->times->map(function ($time) {
                    //             return [
                    //                 'from' => $time->from,
                    //                 'to' => $time->to,
                    //             ];
                    //         }),
                    //     ];
                    // }),
                ];
            })
        ];
    }
}
