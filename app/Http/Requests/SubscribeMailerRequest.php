<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class SubscribeMailerRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:mailer,email,NULL,id,deleted_at,NULL,is_subscribed,1',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'الحقل مطلوب',
            'email.email' => 'برجاء ادخال ايميل صحيح',
            'email.unique' => 'هذا الايميل مشترك بالفعل',
        ];
    }
}
