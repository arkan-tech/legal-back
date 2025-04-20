<?php

namespace App\Http\Requests\API\Client\Device;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class ClientCreateDeviceRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'device_id'=>'required',
            'fcm_token'=>'required',
            'type'=>'required|numeric|in:1,2'

        ];
    }

}
