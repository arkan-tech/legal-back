<?php

namespace App\Http\Requests;

use App\Rules\ValidReferralCode;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterAccountRequest extends BaseRequest
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
            'phone' => 'required|string|unique:accounts,phone,NULL,id,deleted_at,NULL',
            'phone_code' => 'required|integer',
            'email' => 'required|email|unique:accounts,email,NULL,id,deleted_at,NULL',
            'password' => 'required|string|min:8',
            'account_type' => 'required|in:client,lawyer',
            'name' => 'required_if:account_type,client|not_contains:ـ',
            'first_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'second_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'third_name' => 'nullable|string|not_contains:ـ',
            'fourth_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'referred_by' => ['sometimes', new ValidReferralCode()],
            'otp' => 'required_if:phone_code,966|string|min_digits:6',
            'gender' => "nullable|in:Male,Female",
            'accepted_tos' => "required|in:1"
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.not_contains' => 'الاسم لا يجب أن يحتوي على الحرف ـ',
            'first_name.required' => 'الاسم الاول مطلوب',
            'first_name.not_contains' => 'الاسم الأول لا يجب أن يحتوي على الحرف ـ',
            'second_name.required' => 'الاسم الثاني مطلوب',
            'second_name.not_contains' => 'الاسم الثاني لا يجب أن يحتوي على الحرف ـ',
            'fourth_name.required' => 'الاسم الرابع مطلوب',
            'fourth_name.not_contains' => 'الاسم الرابع لا يجب أن يحتوي على الحرف ـ',
            'third_name.not_contains' => 'الاسم الثالث لا يجب أن يحتوي على الحرف ـ',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني يجب ان يكون بالشكل الصحيح',
            'email.unique' => ' البريد الإلكتروني موجود مسبقاً',

            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.numeric' => 'رقم الهاتف يجب ان يكون ارقام',
            'phone.unique' => 'رقم الهاتف موجود سابقاً',
            'phone_code.required' => 'مقدمة الدولة مطلوبة',
            'phone_code.numeric' => 'مقدمة الدولة يجب ان تكون ارقام',

            'account_type.required' => 'نوع الحساب مطلوب',
            'account_type.in' => ' نوع الحساب يجب ان يكون ضمن [lawyer,client]',

            'password.required' => 'كلمة المرور مطلوب',

            'gender.in' => 'يجب ان يكون الجنس Male او Female',
            'gender.required' => 'الجنس  مطلوب',
            'referred_by.valid_referral_code' => 'رمز المشاركة غير صحيح',

            'otp.required_if' => "برجاء تفعيل رقم الهاتف",
            'accepted_tos' => "يجب الموافقة على الشروط والأحكام"

        ];
    }
}
