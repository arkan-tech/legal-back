<?php

namespace App\Http\Resources\API\Services;

use App\Models\ElectronicOffice\Services\Services;
use App\Models\Service\Service;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServiceSubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $services = Service::where('category_id',$this->id)->get();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'services'=>new ServicesResource($services)
        ];
    }
}
