<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountBankInfoRequest extends BaseRequest
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
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => 'اسم البنك مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
        ];
    }
}
