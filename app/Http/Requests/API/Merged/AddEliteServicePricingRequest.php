<?php

namespace App\Http\Requests\API\Merged;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddEliteServicePricingRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            "elite_service_request_id" => "required|exists:elite_service_requests,id",
            "advisory_service_sub_id" => "nullable|exists:advisory_services_sub_categories,id",
            "advisory_service_date" => "sometimes|nullable|date",
            "advisory_service_from_time" => "sometimes|nullable|date_format:H:i",
            "advisory_service_to_time" => "sometimes|nullable|date_format:H:i",
            "advisory_service_sub_price" => "required_with:advisory_service_sub_id|nullable",
            "service_sub_id" => "nullable|exists:services,id",
            "service_sub_price" => "required_with:service_sub_id|nullable",
            "reservation_type_id" => "nullable|exists:reservation_types,id",
            "reservation_price" => "required_with:reservation_type_id|nullable",
            "reservation_date" => "required_with:reservation_type_id|nullable|date",
            "reservation_from_time" => "required_with:reservation_type_id|nullable|date_format:H:i",
            "reservation_to_time" => "required_with:reservation_type_id|nullable|date_format:H:i",
            "reservation_latitude" => "required_with:reservation_type_id|nullable",
            "reservation_longitude" => "required_with:reservation_type_id|nullable",
        ];
    }

    public function messages()
    {
        // Custom validation messages in Arabic
        return [
            'elite_service_request_id.required' => 'حقل الطلب مطلوب.',
            'elite_service_request_id.exists' => 'الطلب المحدد غير موجودة.',
            'advisory_service_sub_id.exists' => 'الفئة الفرعية للخدمة الاستشارية المحددة غير موجودة.',
            'advisory_service_sub_price.required_with' => 'يجب إدخال سعر الفئة الفرعية للخدمة الاستشارية إذا كانت الفئة الفرعية موجودة.',
            'advisory_service_sub_price.numeric' => 'يجب أن يكون سعر الفئة الفرعية للخدمة الاستشارية رقمًا.',
            'service_sub_id.exists' => 'الفئة الفرعية للخدمة المحددة غير موجودة.',
            'service_sub_price.required_with' => 'يجب إدخال سعر الفئة الفرعية للخدمة إذا كانت الفئة الفرعية موجودة.',
            'service_sub_price.numeric' => 'يجب أن يكون سعر الفئة الفرعية للخدمة رقمًا.',
            'reservation_type_id.exists' => 'نوع الموعد المحدد غير موجود.',
            'reservation_price.required_with' => 'يجب إدخال سعر الموعد إذا كان نوع الموعد موجود.',
            'reservation_price.numeric' => 'يجب أن يكون سعر الموعد رقمًا.',
        ];
    }
}
