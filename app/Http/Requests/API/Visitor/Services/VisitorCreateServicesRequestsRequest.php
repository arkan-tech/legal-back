<?php

namespace App\Http\Requests\API\Visitor\Services;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitorCreateServicesRequestsRequest extends BaseRequest
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
            'priority' => 'required|numeric|exists:client_reservations_importance,id',
            'description' => 'required',
            'file' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'accept_rules' => 'required|in:1',
            'name'=>'required',
            'email'=>'required|email|unique:service_users,email',
            'mobile'=>'required|numeric|unique:service_users,mobil',
            'type'=>'required|numeric|in:1,2,3,4,5',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'حقل المحتوى مطلوب ',
            'service_id.required' => 'حقل الخدمة مطلوب ',
            'service_id.numeric' => 'حقل الخدمة يجب ان يكون ارقام ',
            'service_id.exists' => 'حقل الخدمة غير موجود ',
            'priority.required' => 'حقل الاهمية مطلوب ',
            'priority.numeric' => 'حقل الاهمية يجب ان يكون ارقام ',
            'priority.exists' => 'حقل الاهمية غير موجود ',
            'file.mimes' => 'حقل الملف يجب ان يكون بصيغة png,jpg,jpeg,PNG,JPG,JPEG ',
            'accept_rules.required' => 'حقل الموافقة على الشروط مطلوب',
            'accept_rules.in' => 'يجب الموافقة على حقل الموافقة على الشروط ',

            'name.required'=>'حقل الاسم مطلوب',
            'email.required'=>'حقل الايميل مطلوب',
            'email.email'=>'حقل الايميل يجب ان يكون بالشكل الصحيح',
            'email.unique'=>' الايميل موجود مسبقاً',
            'mobile.required'=>'حقل الموبايل مطلوب',
            'mobile.numeric'=>'حقل الموبايل يجب ان يكون ارقام',
            'mobile.unique'=>' الموبايل موجود سابقاً',
            'type.required'=>'حقل  النوع مطلوب',
            'type.numeric'=>'حقل  النوع يجب ان يكون ارقام',
            'type.in'=>'حقل  النوع يجب ان يكون ضمن [ 1,2,3,4,5]',
        ]; // TODO: Change the autogenerated stub
    }
}
