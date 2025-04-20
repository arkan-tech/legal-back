<?php

namespace App\Http\Requests\API\Client\Reservations\YmtazReservations;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientCreateYmtazReservationRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'service_id' => 'required|numeric|exists:services,id',
            'description' => 'required',
            'file' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf,PDF',
            'ymtaz_date_id' => 'required|numeric|exists:ymtaz_available_dates,id',
            'ymtaz_time_id' => 'required|numeric|exists:ymtaz_available_dates_times,id',
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'حقل الخدمة مطلوب ',
            'service_id.numeric' => 'حقل الخدمة غير صحيح ',
            'service_id.exists' => 'حقل الخدمة غير صحيح',
            'description.required' => 'حقل الوصف مطلوب',
            'file.mimes' => 'صيغة الملف مرفوضة',
            'ymtaz_date_id.required' => 'التاريخ مطلوب',
            'ymtaz_date_id.numeric' => 'التاريخ غير صحيح ',
            'ymtaz_date_id.exists' => 'التاريخ غير متاح',
            'ymtaz_time_id.required' => 'الوقت مطلوب',
            'ymtaz_time_id.numeric' => 'الوقت غير صحيح ',
            'ymtaz_time_id.exists' => 'الوقت غير متاح',

        ];
    }
}
