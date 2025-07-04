<?php

namespace App\Http\Requests\API\Client\DigitalGuide;

use App\Http\Requests\API\BaseRequest;

class getLawyersBaseFilterRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => 'sometimes|numeric|exists:digital_guide_sections,id',
            'country_id' => 'sometimes|numeric|exists:countries,id',
            'city_id' => 'sometimes|numeric|exists:cities,id',
            'district_id' => 'sometimes|numeric|exists:districts,id',
            'gender' => 'sometimes|in:Male,Female',
            'name' => 'sometimes',
            'general_search_input' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'category_id.numeric' => 'حقل المهنة يجب ان يكون رقم فقط ',
            'category_id.exists' => 'حقل المهنة غير موجود ',

            'country_id.numeric' => 'حقل الدولة يجب ان يكون رقم فقط ',
            'country_id.exists' => 'حقل الدولة غير موجود ',

            'city_id.numeric' => 'حقل المدينة يجب ان يكون رقم فقط ',
            'city_id.exists' => 'حقل المدينة غير موجود ',

            'district_id.numeric' => 'حقل الحي يجب ان يكون رقم فقط ',
            'district_id.exists' => 'حقل الحي غير موجود ',
            'gender.in' => 'حقل الحي غير صحيح يجب ان تكون بين خيارين (Male , Female) ',
        ]; // TODO: Change the autogenerated stub
    }
}
