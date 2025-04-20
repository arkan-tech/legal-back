<?php

namespace App\Http\Requests\Site\Lawyer\Auth;

use App\Models\Country\Country;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuideCategories;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterSiteRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request = request()->all();

        $type = [2, 3];
        $identity_type = [1, 3];
        $type2 = [4, 5];

        $check_type_required = in_array($request['type'], $type) ? 'required' : 'sometimes';

        $check_type_required2 = in_array($request['type'], $type2) ? 'required' : 'sometimes';

        $check_identity_types_need_numeric = in_array($request['identity_type'], $type) ? 'numeric' : '';
        $check_identity_types_need_required = in_array($request['identity_type'], $identity_type) ? 'required' : '';

        $check_if_section_need_licences = false;
        if (array_key_exists('sections', $request)) {
            foreach ($request['sections'] as $section) {
                $item = DigitalGuideCategories::where('status', 1)->where('id', $section)->first();
                if (!is_null($item)) {
                    if ($item->need_license == 1) {
                        $check_if_section_need_licences = true;
                    }
                }
            }
        }
        if (array_key_exists('degree', $request)) {
            $degree = Degree::where('id', $request['degree'])->first();
            $check_degree_need_certificate = false;
            if (!is_null($degree)) {
                if ($degree->need_certificate == 1) {
                    $check_degree_need_certificate = true;
                }
            }
        }

        if (array_key_exists('country_id', $request)) {
            $country = Country::where('id', $request['country_id'])->first();
            $check_country_status = false;
            if (!is_null($country)) {
                if ($country->phone_code == 966) {
                    $check_country_status = true;
                }
            }
        }


        return [
            //            first page
            'fname' => 'required',
            'sname' => 'required',
            'tname' => 'sometimes',
            'fourthname' => 'required',
            'email' => ['required', 'email', Rule::unique('service_users', 'email')->whereNull('deleted_at'), Rule::unique('lawyers', 'email')->whereNull('deleted_at')],
            'phone' => ['required', 'numeric', Rule::unique('service_users', 'mobil')->whereNull('deleted_at'), Rule::unique('lawyers', 'phone')->whereNull('deleted_at')],
            'phone_code' => 'required',
            'password' => 'required',


            //            second page
            'about' => 'required',
            'gender' => 'required|in:Male,Female',
            'degree' => 'required|numeric|exists:degrees,id',
//            'degree_certificate' => $check_degree_need_certificate ? 'required' : 'sometimes' . '|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'degree_certificate' =>  'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'general_specialty' => 'required|numeric|exists:general_specialty,id',
            'accurate_specialty' => 'required|numeric|exists:accurate_specialty,id',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',

//            third page
            'nationality' => 'required|numeric|exists:nationalities,id',
            'country_id' => 'required|numeric|exists:countries,id',
            'region' => $check_country_status ? 'required' : 'sometimes' ,
            'city' => $check_country_status ? 'required' : 'sometimes' ,
            'lat' => 'sometimes',
            'lon' => 'sometimes',

//            fourth page
            'type' => 'required|numeric|exists:lawyer_types,id',
            'identity_type' => 'required|numeric|in:1,2,3,4',
            //            يجب التحقق من ان يكون ارقام فقط في حال كانت نوع الهوية هوية شخصية وغير هيك يكون ارقام واحرف
            'nat_id' => 'required|',
            'functional_cases' => 'required|numeric|exists:functional_cases,id',
//            fifth page
            'photo' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'logo' => [ 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG'],
            'cv' => 'required_if:type,1|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'id_file' => $check_identity_types_need_required.'|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'company_lisences_no' => [$check_type_required],
            'company_lisences_file' => [$check_type_required, 'mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf'],
            'company_name' => [$check_type_required2],

        ];
    }

    public function messages()
    {
        return [

            'fname.required' => 'الاسم الاول مطلوب ',
            'sname.required' => 'الاسم الثاني مطلوب',
            'tname.required' => 'الاسم الثالث مطلوب',
            'fourthname.required' => 'الاسم الرابع مطلوب',
            'email.required' => 'البريد الالكتروني مطلوب ',
            'email.email' => 'البريد الالكتروني  خطأ ',
            'email.unique' => 'البريد الالكتروني موجود مسبقاً ',

            'phone.unique' => 'الجوال موجود مسبقا',
            'phone.numeric' => 'الجوال خطأ يجب ان يكون ارقام فقط ',
            'phone.required' => ' رقم الجوال مطلوب',
            'phone.max' => 'يجب ان لا يتجاوز 12 رقم',
            'phone.min' => 'يجب ان  يكون 12 رقم',

            'password.required' => 'الحقل مطلوب',
            'about.required' => 'الحقل مطلوب',
            'gender.required' => 'الحقل مطلوب',
            'gender.in' => 'خطأ في البيانات',
            'degree.numeric' => 'خطأ في البيانات',
            'degree.exists' => 'خطأ في البيانات',
            'degree.required' => 'الحقل مطلوب',
            'general_specialty.numeric' => 'خطأ في البيانات',
            'general_specialty.exists' => 'خطأ في البيانات',
            'general_specialty.required' => 'الحقل مطلوب',
            'accurate_specialty.numeric' => 'خطأ في البيانات',
            'accurate_specialty.exists' => 'خطأ في البيانات',
            'accurate_specialty.required' => 'الحقل مطلوب',
            'rules.in' => 'يجب الموافقة على الشروط',


        ]; // TODO: Change the autogenerated stub
    }
}
