<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequestValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'appointment_sub_id' => 'required|integer|exists:appointments_sub_category,id',
            'importance_id' => 'required|integer|exists:client_reservations_importance,id',
            'account_id' => 'required|integer|exists:accounts,id',
            'lawyer_id' => 'required|integer|exists:accounts,id',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
        ];
    }
}
