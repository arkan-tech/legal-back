<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckForgetPasswordTokenRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:reset_passwords,email',
            'token' => 'required|string',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني عنوان بريد إلكتروني صالح.',
            'email.exists' => 'البريد الإلكتروني غير موجود في قاعدة بيانات إعادة تعيين كلمة المرور.',
            'token.required' => 'الرمز مطلوب.',
        ];
    }
}
