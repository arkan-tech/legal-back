<?php

namespace App\Http\Resources\API\Lawyer\GeneralData\LawyerTypes;

use App\Http\Resources\API\Lawyer\GeneralData\Regions\LawyerRegionsResource;
use App\Models\Regions\Regions;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class LawyerLawyerTypesResource extends JsonResource
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
            'name' => $this->type_name,
            'need_company_name' => $this->need_company_name,
            'need_company_licence_no' => $this->need_company_licence_no,
            'need_company_licence_file' => $this->need_company_licence_file,
        ];
    }
}
