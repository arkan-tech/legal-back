<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class BookReservationRequest extends BaseRequest
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
            //
            'hours' => 'required',
            'region_id' => 'required',
            'city_id' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'reservation_type_id' => 'required',
            'importance_id' => 'required',
            'description' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'from' => 'required|date_format:H:i',
            // 'to' => 'required|date_format:H:i|after:from',
            'lawyer_ids' => 'required|array|min:1',
            'lawyer_ids.*' => 'exists:accounts,id',
            'file' => 'nullable|file',
        ];
    }

    public function messages()
    {
        return [
            '*.required' => "الحقل مطلوب"
        ];
    }

}
