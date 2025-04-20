<?php

namespace App\Http\Requests\API\Lawyer\Auth\Register;

use App\Http\Requests\API\BaseRequest;
use App\Models\Country\Country;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Validation\Rule;

class LawyerCheckVerificationFirstStepRequest extends BaseRequest
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
            'email' => ['required', 'email', Rule::unique('service_users', 'email')->whereNull('deleted_at'), Rule::unique('lawyers', 'email')->whereNull('deleted_at')],
            'phone' => ['required', 'numeric', Rule::unique('service_users', 'mobil')->whereNull('deleted_at'), Rule::unique('lawyers', 'phone')->whereNull('deleted_at')],


            'phone_code' => 'required|numeric',
            'otp' => 'required|numeric|exists:lawyers_first_step_verification,otp',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني موجود سابقاً',

            'phone.required' => 'رقم الجوال مطلوب',
            'phone.unique' => 'رقم الجوال موجود سابقاً',

            'phone_code.required' => 'مقدمة الجوال مطلوب',
            'phone_code.unique' => 'مقدمة الجوال موجود سابقاً',

            'otp.required' => 'رمز التحقق مطلوب',
            'otp.numeric' => 'رمز التحقق يجب ان يكون ارقام  ',
            'otp.exists' => 'رمز التحقق خطأ ',

        ];
    }
}
