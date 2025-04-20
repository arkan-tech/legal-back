<?php

namespace App\Http\Resources\API\Client\ContactYmtaz;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ClientContactYmtazResource extends JsonResource
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
            'subject' => $this->subject,
            'message' => $this->details,
            'file' => $this->file,
            'ymtaz_reply_subject' => $this->ymtaz_reply_subject,
            'ymtaz_reply_message' => $this->reply,
        ];
    }
}
