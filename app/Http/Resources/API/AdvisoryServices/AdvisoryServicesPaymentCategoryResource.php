<?php

namespace App\Http\Resources\API\AdvisoryServices;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class AdvisoryServicesPaymentCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
		$payment_method;
		switch($this->payment_method){
			case 1:
				$payment_method = "مجانية";
				break;
			case 2:
				$payment_method = "مدفوعة";
				break;
			case 3:
				$payment_method = "متخصصة";
				break;
		}
        return [
            'id' => $this->id,
            'name' => $this->name,
            'payment_method' => $payment_method,
            'count' => $this->count,
            'period' => $this->period,
        ];
    }
}
