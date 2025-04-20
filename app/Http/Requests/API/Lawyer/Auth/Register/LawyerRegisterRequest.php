<?php

namespace App\Http\Requests\API\Lawyer\Auth\Register;

use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use App\Models\Country\Country;
use Illuminate\Validation\Rule;
use App\Rules\ValidReferralCode;
use App\Models\Service\ServiceUser;
use App\Http\Requests\API\BaseRequest;
use App\Models\DigitalGuide\DigitalGuideCategories;

class LawyerRegisterRequest extends BaseRequest
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
        $request = request()->all();
        $phone_code = request()->get('phone_code');
        $type = [2, 3];

        $type2 = [4, 5];

        $check_type_required = in_array($request['type'], $type) ? 'required' : 'sometimes';

        $check_type_required2 = in_array($request['type'], $type2) ? 'required' : 'sometimes';

        $check_identity_types_need_numeric = in_array($request['identity_type'], $type) ? 'numeric' : '';


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

        // if (array_key_exists('degree', $request)) {
        //     $degree = Degree::where('isYmtaz', 1)->where('id', $request['degree'])->first();
        //     $check_degree_need_certificate = false;
        //     if (!is_null($degree)) {
        //         if ($degree->need_certificate == 1) {
        //             $check_degree_need_certificate = true;
        //         }
        //     }
        // }


        if (array_key_exists('country', $request)) {
            $country = Country::where('id', $request['country'])->first();
            $check_country_status = false;
            if (!is_null($country)) {
                if ($country->phone_code == 966) {
                    $check_country_status = true;
                }
            }
        }


        $rules = [

            //            first page
            'first_name' => 'required',
            'second_name' => 'required',
            'third_name' => 'sometimes',
            'fourth_name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $lawyerExists = Lawyer::where('email', $value)->whereNull('deleted_at')->exists();
                    $clientExists = ServiceUser::where('email', $value)->whereNull('deleted_at')->exists();

                    if ($lawyerExists || $clientExists) {
                        $fail('البريد الإلكتروني موجود مسبقا');
                    }
                }
            ],
            'phone' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($phone_code) {
                    $lawyerExists = Lawyer::where('phone', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->exists();
                    $clientExists = ServiceUser::where('mobil', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->exists();

                    if ($lawyerExists || $clientExists) {
                        $fail('هذا الرقم موجود مسبقا');
                    }
                }
            ],

            'phone_code' => 'required',
            'password' => 'required|confirmed',
            'accept_rules' => 'required|in:1',


            //            second page
            'about' => 'required',
            'birth_day' => 'required|numeric',
            'birth_month' => 'required|numeric',
            'birth_year' => 'required|numeric',

            'gender' => 'required|in:Male,Female',
            'degree' => 'required|numeric|exists:degrees,id',
            'other_degree' => 'sometimes',
            //            'degree_certificate' => $check_degree_need_certificate ? 'required' : 'sometimes' . '|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'degree_certificate' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'general_specialty' => 'required|numeric|exists:general_specialty,id',
            'accurate_specialty' => 'required|numeric|exists:accurate_specialty,id',


            //            third page
            'nationality' => 'required|numeric|exists:nationalities,id',
            'country' => 'required|numeric|exists:countries,id',
            'region' => $check_country_status ? 'required' : 'sometimes' . '|numeric|exists:regions,id',
            'city' => $check_country_status ? 'required' : 'sometimes' . '|numeric|exists:cities,id',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',

            //            fourth page
            'type' => 'required|numeric|exists:lawyer_types,id',
            'identity_type' => 'required|numeric|in:1,2,3,4',
            //            يجب التحقق من ان يكون ارقام فقط في حال كانت نوع الهوية هوية شخصية وغير هيك يكون ارقام واحرف
            'nat_id' => 'required|' . $check_identity_types_need_numeric,
            'functional_cases' => 'required|numeric|exists:functional_cases,id',
            'sections' => 'required|array',
            'sections*' => 'required|numeric|exists:digital_guide_sections,id',
            //يجب الرسال مصفوفة['رقم المهنة']->'الترخيص الخاص فيها '
            'licence_no' => [$check_if_section_need_licences ? 'required' : 'sometimes', 'array'],
            'licence_no.*' => [$check_if_section_need_licences ? 'required' : 'sometimes', 'numeric'],
            ////يجب الرسال مصفوفة['رقم المهنة']->'الترخيص الخاص فيها'
            'license_file' => [$check_if_section_need_licences ? 'required' : 'sometimes', 'array'],
            'license_file.*' => [$check_if_section_need_licences ? 'required' : 'sometimes', 'mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf'],


            //            fifth page
            'photo' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'logo' => [$check_type_required, 'mimes:png,jpg,jpeg,PNG,JPG,JPEG'],
            'cv' => 'required_if:type,1|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'id_file' => 'required_if:type,1|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'company_lisences_no' => [$check_type_required, 'numeric'],
            'company_lisences_file' => [$check_type_required, 'mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf'],
            'company_name' => [$check_type_required2],
            'languages' => "required|array|min:1",
            'referred_by' => ['sometimes', new ValidReferralCode()]
        ];

        $degree = Degree::where('isYmtaz', 1)->find($request['degree']);
        if ($degree->title == "أخرى") {
            $rules['other_degree'] = 'required';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            //        Start first page

            'first_name.required' => 'الاسم الاول مطلوب',
            'second_name.required' => 'الاسم الثاني مطلوب',
            'third_name.required' => 'الاسم الثالث مطلوب',
            'fourth_name.required' => 'الاسم الرابع مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني موجود مسبقاً',
            'phone.unique' => 'رقم الجوال موجود مسبقا',
            'phone.numeric' => ' رقم الجوال يجب ان يكون ارقام فقط ',
            'phone.required' => ' رقم الجوال مطلوب ',
            'password.required' => '  كلمة المرور مطلوب ',
            'password.confirmed' => ' تأكيد كلمة المرور مطلوب ',
            'accept_rules.required' => ' يجب الموافقة على السياسات والشروط ',
            'accept_rules.in' => ' يجب الموافقة على السياسات والشروط ويجب ان يكون قيمته 1',
            //        end first page


            //        Start second page

            'about.required' => '  نبذة قصيرة مطلوب ',
            'birth_day.required' => '  يوم الميلاد مطلوب ',
            'birth_day.numeric' => '  يوم الميلاد يجب ان يكون ارقام ',
            'birth_month.required' => '  شهر الميلاد مطلوب ',
            'birth_month.numeric' => '  شهر الميلاد يجب ان يكون ارقام ',
            'birth_year.required' => '  سنة الميلاد مطلوب ',
            'birth_year.numeric' => '  سنة الميلاد يجب ان يكون ارقام ',
            'gender.in' => '  يجب ان يكون الجنس Male او Female ',
            'gender.required' => '  الجنس  مطلوب ',
            'degree.numeric' => '    الدرجة العلمية يجب ان يكون ارقام  ',
            'degree.required' => '  الدرجة العلمية  مطلوب ',
            'degree.exists' => '  الدرجة العلمية  غير موجود ',
            'other_degree.required' => "اسم الدرجة العلمية الأخرى مطلوب",
            'degree_certificate.required' => '  الدرجة العلمية تحتاج إلى شهادة اثبات ',
            'general_specialty.numeric' => '  التخصص العام يجب ان يكون ارقام  ',
            'general_specialty.required' => '  التخصص العام  مطلوب ',
            'general_specialty.exists' => '  التخصص العام  غير موجود ',
            'accurate_specialty.numeric' => '  التخصص الدقيق يجب ان يكون ارقام  ',
            'accurate_specialty.required' => '  التخصص الدقيق  مطلوب ',
            'accurate_specialty.exists' => '  التخصص الدقيق  غير موجود ',
            //        end second page

            //        start    third page
            'nationality.required' => 'حقل الجنسية مطلوب',
            'nationality.numeric' => 'حقل الجنسية يجب ان يكون ارقام',
            'nationality.exists' => 'حقل الجنسية غير موجود وغير صحيح',
            'country.required' => 'حقل الدولة مطلوب',
            'country.numeric' => 'حقل الدولة يجب ان يكون ارقام',
            'country.exists' => 'حقل الدولة غير موجود وغير صحيح',
            'region.required' => 'حقل المنطقة مطلوب',
            'region.numeric' => 'حقل المنطقة يجب ان يكون ارقام',
            'region.exists' => 'حقل المنطقة غير موجود وغير صحيح',
            'city.required' => 'حقل المدينة مطلوب',
            'city.numeric' => 'حقل المدينة يجب ان يكون ارقام',
            'city.exists' => 'حقل المدينة غير موجود وغير صحيح',
            'longitude.required' => 'حقل longitude مطلوب',
            'longitude.numeric' => 'حقل longitude يجب ان يكون ارقام',
            'latitude.required' => 'حقل longitude مطلوب',
            'latitude.numeric' => 'حقل longitude يجب ان يكون ارقام',
            //        end    third page

            //         start  fourth page


            'type.required' => 'حقل الصفة مطلوب',
            'type.numeric' => 'حقل الصفة غير صحيح يجب ان يكون ارقام',
            'type.exists' => 'حقل الصفة غير موجود',
            'identity_type.required' => 'حقل نوع الهوية مطلوب',
            'identity_type.numeric' => 'حقل نوع الهوية غير صحيح يجب ان يكون ارقام',
            'identity_type.in' => 'حقل نوع الهوية يجب ان يكون ضمن [1,2,3,4]',
            'nat_id.required' => 'حقل الهوية مطلوب',
            'nat_id.numeric' => ' حقل  الهوية غير صحيح يجب ان يكون ارقام فقط',
            'functional_cases.numeric' => '  التخصص الحالة الوظيفية يجب ان يكون ارقام  ',
            'functional_cases.required' => '  التخصص الحالة الوظيفية  مطلوب ',
            'functional_cases.exists' => ' التخصص الحالة الوظيفية  غير موجود ',

            'sections.required' => ' يجب اختيار مهن ',
            'sections*.required' => ' يجب اختيار مهن ',
            'sections*.numeric' => ' حقل المهن يجب ان يكون ارقام ',
            'sections*.exists' => ' حقل المهن غير موجود ',

            'licence_no.required' => ' يجب ادراج ارقام الترخيص ',
            'licence_no.*.required' => ' يجب ادراج ارقام الترخيص ',
            'licence_no.*.numeric' => ' يجب ادراج ارقام الترخيص على ان تكون ارقام فقط',

            'license_file.required' => ' يجب ادراج ملفات الترخيص ',
            'license_file.*.required' => ' يجب ادراج ملفات الترخيص ',
            'license_file.*.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf ملفات الترخيص يجب ان تكون بصيغة التالي : ',

            //         end    fourth page

            'logo.required' => 'يجب اختيار الشعار ',
            'logo.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf الشعار يجب ان يكون بالصيغ التالية : ',

            'cv.required_if' => 'يجب ادخال الcv اذا كان الصفة فرد ',
            'cv.mimes' => 'pdf الcv يجب ان يكون بالصيغ التالية : ',

            'id_file.required_if' => 'يجب ادخال الهوية اذا كان الصفة فرد ',
            'id_file.mimes' => 'png,jpg,jpeg,PNG,JPG,JPEG,pdf الهوية يجب ان يكون بالصيغ التالية : ',

            'company_lisences_no.required' => 'يجب ادخال رقم السجل التجاري ',
            'company_lisences_no.numeric' => 'يجب ادخال رقم السجل التجاري بشكل صحيح ويجب ان يكون ارقام فقط',

            'company_lisences_file.required' => 'يجب ادخال رقم السجل التجاري ',
            'company_lisences_file.mimes' => 'pdf السجل التجاري يجب ان يكون بالصيغ التالية : ',
            'company_name.required' => 'يجب ادخال اسم المنشأة ',
            'referred_by.valid_referral_code' => 'رمز المشاركة غير صحيح'

        ]; // TODO: Change the autogenerated stub
    }
}
