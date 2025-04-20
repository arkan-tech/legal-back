<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CheckPhoneRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone_code' => 'required|integer|in:966',
            'phone' => 'required|string|unique:accounts,phone,NULL,id,deleted_at,NULL'
        ];
    }

    public function messages()
    {
        return [
            'phone_code.required' => 'يجب عليك ادخال رمز الهاتف',
            'phone_code.integer' => 'يجب عليك ادخال رمز الهاتف بشكل صحيح',
            'phone_code.in' => 'يجب عليك ادخال رمز الهاتف بشكل صحيح',
            'phone.required' => 'يجب عليك ادخال رقم الهاتف',
            'phone.string' => 'يجب عليك ادخال رقم الهاتف بشكل صحيح',
            'phone.unique' => 'رقم الهاتف موجود سابقاً',

        ];
    }

}
