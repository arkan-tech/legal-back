<?php

namespace App\Http\Requests\API\Lawyer\Auth\Password;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LawyerPostForgotPasswordRequest extends BaseRequest
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
            'email'=>'required|email|exists:lawyers,email',

        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'حقل البريد الاكتروني مطلوب',
            'email.email'=>'حقل البريد الاكتروني يجب ان يكون بشكل صحيح',
            'email.exists'=>'حقل البريد الاكتروني غير موجود',

        ]; // TODO: Change the autogenerated stub
    }
}
