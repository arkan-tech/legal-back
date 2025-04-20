<?php

namespace App\Http\Requests;

use App\Http\Requests\API\BaseRequest;
use App\Models\Account;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends BaseRequest
{

    public function rules(): array
    {
        $account_id = auth()->guard('api_account')->user()->id;
        $phone_code = request()->get('phone_code');

        return [
            'email' => [
                "required",
                'email',
                function ($attribute, $value, $fail) use ($account_id) {
                    // Rule::unique('lawyers', 'email')->ignore($u_id)->whereNull('deleted_at')
                    $userExists = Account::where('email', $value)->whereNull('deleted_at')->where('id', '!=', $account_id)->exists();

                    if ($userExists) {
                        $fail('البريد الإلكتروني موجود مسبقا');
                    }
                }
            ],
            'phone' => [
                "required",
                function ($attribute, $value, $fail) use ($account_id, $phone_code) {
                    $accountExists = Account::where('phone', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->where('id', '!=', $account_id)->exists();

                    if ($accountExists) {
                        $fail('هذا الرقم موجود مسبقا');
                    }
                }
            ],
            'phone_code' => "required",
            'otp' => 'sometimes',
            'password' => "sometimes",
            'region_id' => "required|exists:regions,id",
            'city_id' => "required|exists:cities,id",
            'country_id' => "required|exists:countries,id",
            'nationality_id' => "required|exists:nationalities,id",
            'type' => "required|in:1,2,3,4,5",
            'account_type' => "required|in:lawyer,client",
            'name' => 'required_if:account_type,client|not_contains:ـ',
            'profile_photo' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'gender' => "required|in:Male,Female",
            'longitude' => "required",
            'latitude' => "required",

            'first_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'second_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'third_name' => 'sometimes|string|not_contains:ـ',
            'fourth_name' => 'required_if:account_type,lawyer|string|not_contains:ـ',
            'sections' => 'sometimes|array',
            'sections*' => 'sometimes|numeric|exists:digital_guide_sections,id',
            'degree' => "required_if:account_type,lawyer",
            'other_degree' => "sometimes",
            'degree_certificate' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'about' => "required_if:account_type,lawyer",
            'national_id' => "required_if:account_type,lawyer",
            'national_id_image' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'license_no' => "sometimes",
            'license_no.*' => "sometimes",
            'license_image' => "sometimes",
            'license_image.*' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'day' => "required_if:account_type,lawyer",
            'month' => "required_if:account_type,lawyer",
            'year' => "required_if:account_type,lawyer",
            'general_specialty' => "required_if:account_type,lawyer|exists:general_specialty,id",
            'accurate_specialty' => "required_if:account_type,lawyer|exists:accurate_specialty,id",
            'functional_cases' => "required_if:account_type,lawyer|exists:functional_cases,id",
            'cv_file' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'company_name' => "sometimes",
            'company_licenses_no' => "sometimes",
            'company_license_file' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'identity_type' => "required_if:account_type,lawyer",
            // 'other_identity_type' => "required_if:account_type,lawyer",
            'logo' => "sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf",
            'languages' => 'sometimes|array',
            'languages.*' => "numeric|exists:languages,id"
        ];
    }

    public function messages()
    {
        return [

            'name.required_if' => 'الاسم مطلوب',
            'first_name.required_if' => 'الاسم الاول مطلوب ',
            'first_name.not_contains' => 'الاسم الأول لا يجب أن يحتوي على الحرف ـ',
            'name.not_contains' => 'الاسم لا يجب أن يحتوي على الحرف ـ',
            'second_name.not_contains' => 'الاسم الثاني لا يجب أن يحتوي على الحرف ـ',
            'third_name.not_contains' => 'الاسم الثالث لا يجب أن يحتوي على الحرف ـ',
            'second_name.required_if' => 'الاسم الثاني مطلوب ',
            'third_name.required_if' => 'الاسم الثالث مطلوب ',
            'fourth_name.required_if' => 'الاسم الرابع مطلوب ',
            'email.required' => ' الايميل مطلوب ',
            'email.email' => ' الايميل غير صحيح ',
            'email.unique' => ' الايميل  موجود مسبقاً ',
            'phone.unique' => ' رقم الجوال  موجود مسبقاً ',
            'phone.numeric' => ' رقم الجوال يجب ان يكون ارقام فقط ',
            'phone.required' => ' رقم الجوال مطلوب ',
            'password.required' => '  كلمة المرور مطلوب ',
            'password.confirmed' => ' تأكيد كلمة المرور مطلوب ',
            'about.required' => '  نبذة قصيرة مطلوب ',
            'day.required' => '  يوم الميلاد مطلوب ',
            'month.required' => '  شهر الميلاد مطلوب ',
            'year.required' => '  سنة الميلاد مطلوب ',
            'gender.in' => '  يجب ان يكون الجنس Male او Female ',
            'gender.required' => '  الجنس  مطلوب ',
            'degree.required_if' => '  الدرجة العلمية  مطلوب ',
            'degree.exists' => '  الدرجة العلمية  غير موجود ',
            'other_degree.required_if' => "اسم الدرجة العلمية الأخرى مطلوب",

            'degree_certificate.required_if' => '  الدرجة العلمية تحتاج إلى شهادة اثبات ',
            'general_specialty.numeric' => '  التخصص العام يجب ان يكون ارقام  ',
            'general_specialty.required_if' => '  التخصص العام  مطلوب ',
            'general_specialty.exists' => '  التخصص العام  غير موجود ',
            'accurate_specialty.numeric' => '  التخصص الدقيق يجب ان يكون ارقام  ',
            'accurate_specialty.required_if' => '  التخصص الدقيق  مطلوب ',
            'accurate_specialty.exists' => '  التخصص الدقيق  غير موجود ',
            //        end second page

            //        start    third page
            'nationality_id.required' => 'حقل الجنسية مطلوب',
            'nationality_id.numeric' => 'حقل الجنسية يجب ان يكون ارقام',
            'nationality_id.exists' => 'حقل الجنسية غير موجود وغير صحيح',
            'country_id.required' => 'حقل الدولة مطلوب',
            'country_id.numeric' => 'حقل الدولة يجب ان يكون ارقام',
            'country_id.exists' => 'حقل الدولة غير موجود وغير صحيح',
            'region_id.required' => 'حقل المنطقة مطلوب',
            'region_id.numeric' => 'حقل المنطقة يجب ان يكون ارقام',
            'region_id.exists' => 'حقل المنطقة غير موجود وغير صحيح',
            'city_id.required' => 'حقل المدينة مطلوب',
            'city_id.numeric' => 'حقل المدينة يجب ان يكون ارقام',
            'city_id.exists' => 'حقل المدينة غير موجود وغير صحيح',
            'longitude.required' => 'حقل longitude مطلوب',
            'longitude.numeric' => 'حقل longitude يجب ان يكون ارقام',
            'latitude.required' => 'حقل longitude مطلوب',
            'latitude.numeric' => 'حقل longitude يجب ان يكون ارقام',
            //        end    third page

            //         start  fourth page


            'type.required' => 'حقل الصفة مطلوب',
            'type.numeric' => 'حقل الصفة غير صحيح يجب ان يكون ارقام',
            'type.exists' => 'حقل الصفة غير موجود',
            'identity_type.required_if' => 'حقل نوع الهوية مطلوب',
            'identity_type.numeric' => 'حقل نوع الهوية غير صحيح يجب ان يكون ارقام',
            'identity_type.in' => 'حقل نوع الهوية يجب ان يكون ضمن [1,2,3,4]',
            'nat_id.required_if' => 'حقل الهوية مطلوب',
            'nat_id.numeric' => ' حقل  الهوية غير صحيح يجب ان يكون ارقام فقط',
            'functional_cases.numeric' => '  التخصص الحالة الوظيفية يجب ان يكون ارقام  ',
            'functional_cases.required_if' => '  التخصص الحالة الوظيفية  مطلوب ',
            'functional_cases.exists' => ' التخصص الحالة الوظيفية  غير موجود ',

            'sections.required_if' => ' يجب اختيار مهن ',
            'sections*.required_if' => ' يجب اختيار مهن ',
            'sections*.numeric' => ' حقل المهن يجب ان يكون ارقام ',
            'sections*.exists' => ' حقل المهن غير موجود ',

            'licence_no.required_if' => ' يجب ادراج ارقام الترخيص ',
            'licence_no.*.required_if' => ' يجب ادراج ارقام الترخيص ',
            'licence_no.*.numeric' => ' يجب ادراج ارقام الترخيص على ان تكون ارقام فقط',

            'license_file.required_if' => ' يجب ادراج ملفات الترخيص ',
            'license_file.*.required_if' => ' يجب ادراج ملفات الترخيص ',
            'license_file.*.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf ملفات الترخيص يجب ان تكون بصيغة التالي : ',

            //         end    fourth page

            'logo.required_if' => 'يجب اختيار الشعار ',
            'logo.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf الشعار يجب ان يكون بالصيغ التالية : ',

            'cv_file.required_if' => 'يجب ادخال الcv اذا كان الصفة فرد ',
            'cv_file.mimes' => 'pdf الcv يجب ان يكون بالصيغ التالية : ',

            'national_id_image.required_if' => 'يجب ادخال الهوية اذا كان الصفة فرد ',
            'national_id_image.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf الهوية يجب ان يكون بالصيغ التالية : ',

            'company_licences_no.required' => 'يجب ادخال رقم السجل التجاري ',
            'company_licences_no.numeric' => 'يجب ادخال رقم السجل التجاري بشكل صحيح ويجب ان يكون ارقام فقط',

            'company_license_file.required_if' => 'يجب ادخال رقم السجل التجاري ',
            'company_license_file.mimes' => 'pdf السجل التجاري يجب ان يكون بالصيغ التالية : ',
            'company_name.required_if' => 'يجب ادخال اسم المنشأة ',

        ];
    }
}
