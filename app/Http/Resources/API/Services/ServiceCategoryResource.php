<?php

namespace App\Http\Resources\API\Services;

use App\Models\Service\Service;
use App\Models\Service\ServiceSubCategory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ServiceCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $services = ServicesResource::collection(Service::where('category_id', $this->id)->where('isHidden', 0)->get());
        return [
            'id' => $this->id,
            'name' => $this->name,
            'services' => $services
        ];
    }
}
