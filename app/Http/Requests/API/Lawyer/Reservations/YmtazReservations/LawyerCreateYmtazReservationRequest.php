<?php

namespace App\Http\Requests\API\Lawyer\Reservations\YmtazReservations;

use App\Http\Requests\API\BaseRequest;

class LawyerCreateYmtazReservationRequest extends BaseRequest
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
            'importance_id' => 'required|numeric|exists:client_reservations_importance,id',
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
            'importance_id.required' => 'حقل درجة الاهمية مطلوب ',
            'importance_id.numeric' => 'حقل درجة الاهمية غير صحيح',
            'importance_id.exists' => 'حقل درجة الاهمية غير صحيح',
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
