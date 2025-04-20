<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EliteServiceRequestFileResource;
use App\Http\Resources\EliteServiceRequestProductOfferResource;

class EliteServiceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'account_id' => $this->account_id,
            'elite_service_category' => new EliteServiceCategoryResource($this->eliteServiceCategory),
            'description' => $this->description,
            'transaction_complete' => $this->transaction_complete,
            'transaction_id' => $this->transaction_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'files' => EliteServiceRequestFileResource::collection($this->files),
            'offers' => new EliteServiceRequestProductOfferResource($this->offers),
        ];
    }
}
