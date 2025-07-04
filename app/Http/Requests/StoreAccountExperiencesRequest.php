<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreAccountExperiencesRequest extends BaseRequest
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
            '*.title' => 'required|string|max:255',
            '*.company' => 'required|string|max:255',
            '*.from' => 'required|date_format:Y-m-d',
            '*.to' => 'nullable|date_format:Y-m-d|after_or_equal:*.from',
        ];
    }
}
