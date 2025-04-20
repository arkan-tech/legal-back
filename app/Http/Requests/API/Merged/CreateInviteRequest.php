<?php

namespace App\Http\Requests\API\Merged;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateInviteRequest extends BaseRequest
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => [
                "required_without:phone",
                Rule::unique('accounts', 'email')->whereNull('deleted_at'),
            ],
            "phone" => [
                "required_without:email",
                Rule::unique('accounts', 'phone')->whereNull('deleted_at'),
            ],
            "phone_code" => "required_without:email|in:966"
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.required_without' => 'البريد الإلكتروني مطلوب إذا لم يتم تقديم رقم الهاتف',
            'email.unique' => 'البريد الإلكتروني مسجل مسبقاً',
            'phone.required_without' => 'رقم الهاتف مطلوب إذا لم يتم تقديم البريد الإلكتروني',
            'phone.unique' => 'رقم الهاتف مسجل مسبقاً',
            'phone_code.required_without' => 'كود الدولة مطلوب إذا لم يتم تقديم البريد الإلكتروني',
            'phone_code.in' => "كود الدولة يجب ان يكون سعودي"
        ];
    }
}
