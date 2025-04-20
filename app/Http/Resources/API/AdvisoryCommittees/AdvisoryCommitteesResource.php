<?php

namespace App\Http\Resources\API\AdvisoryCommittees;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryCommitteesResource extends JsonResource
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
            'title' => $this->title,
            'image'=>$this->image,
            'advisors_available_counts'=>getAdvisorCatLawyersCount($this->id)
        ];
    }
}
