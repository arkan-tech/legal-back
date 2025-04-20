<?php
namespace App\Http\Resources\API\Lawyer;

use Illuminate\Http\Resources\Json\JsonResource;

class LawyerLanguageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
