<?php

namespace App\Http\Requests\API\Client\Contact;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class SaveContactMessageRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'mobile'=>'required|numeric',
            'email'=>'required|email',
            'message'=>'required',
            'file'=>'sometimes',
        ];
    }
}
