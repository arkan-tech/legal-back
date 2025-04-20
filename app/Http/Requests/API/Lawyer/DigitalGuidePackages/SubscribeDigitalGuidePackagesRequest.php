<?php

namespace App\Http\Requests\API\DigitalGuidePackages;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeDigitalGuidePackagesRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'package_id'=>'required',

        ];
    }
    public function messages()
    {
        return [
            'package_id.required'=>'Package ID is required.',

        ];
    }
}
