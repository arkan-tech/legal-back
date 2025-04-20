<?php

namespace App\Http\Requests\Admin\DigitalGuide;

use App\Models\Account;
use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use App\Models\Country\Country;
use Illuminate\Validation\Rule;
use App\Models\Service\ServiceUser;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\DigitalGuide\DigitalGuideCategories;

class StoreDigitalGhideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        $request = request()->all();
        $u_id = request()->get('id');
        $phone_code = request()->get('phone_code');
        $lawyer = Account::findOrFail($u_id);
        $type = [2, 3];
        $type2 = [4, 5];
        $check_type_required = in_array($request['type'], $type) ? 'required_if:accepted,2' : 'sometimes';
        $check_type_required2 = in_array($request['type'], $type2) ? 'required_if:accepted,2' : 'sometimes';
        if (array_key_exists('degree', $request)) {
            $degree = Degree::where('isYmtaz', 1)->where('id', $request['degree'])->first();
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
        //        $lawyer_cv = is_null($lawyer->cv) &&$lawyer->type == 1 ?'required_if:accepted,2|required_if:type,1':'sometimes';
        $lawyer_cv = is_null($lawyer->cv_file) && $lawyer->type == 1 ? 'sometimes' : 'sometimes';
        //        $lawyer_id_file = is_null($lawyer->id_file)?'required_if:type,1|required_if:accepted,2':'sometimes';
        $lawyer_id_file = is_null($lawyer->national_id_image) ? 'sometimes' : 'sometimes';
        $lawyer_company_lisences_file = is_null($lawyer->company_licences_file) && in_array($request['type'], $type) ? 'required_if:accepted,2' : 'sometimes';


        return [
            //            first page
            'fname' => 'required_if:accepted,2',
            'sname' => 'required_if:accepted,2',
            'tname' => 'sometimes',
            'fourthname' => 'required_if:accepted,2',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($u_id) {
                    // Rule::unique('lawyers', 'email')->ignore($u_id)->whereNull('deleted_at')
                    $accountExists = Account::where('email', $value)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();

                    if ($accountExists) {
                        $fail('البريد الإلكتروني موجود مسبقا');
                    }
                }
            ],
            'phone' => [
                'required_if:accepted,2',
                function ($attribute, $value, $fail) use ($u_id, $phone_code) {
                    $accountExists = Account::where('phone', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();

                    if ($accountExists) {
                        $fail('هذا الرقم موجود مسبقا');
                    }
                }
            ],
            'phone_code' => 'required_if:accepted,2',
            'password' => 'sometimes',


            //            second page
            'about' => 'required_if:accepted,2',
            'gender' => 'required_if:accepted,2',
            'degree' => 'required_if:accepted,2',
            'degree_certificate' => $check_degree_need_certificate ? 'sometimes' : 'sometimes' . '|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'general_specialty' => 'required_if:accepted,2',
            'accurate_specialty' => 'required_if:accepted,2',

            //            third page
            'nationality' => 'required_if:accepted,2',
            'country_id' => 'required_if:accepted,2',
            'region' => $check_country_status ? 'required_if:accepted,2' : 'sometimes',
            'city' => $check_country_status ? 'required_if:accepted,2' : 'sometimes',
            'lat' => 'sometimes',
            'lon' => 'sometimes',

            //            fourth page
            'type' => 'required_if:accepted,2',
            'identity_type' => 'required_if:accepted,2',
            //            يجب التحقق من ان يكون ارقام فقط في حال كانت نوع الهوية هوية شخصية وغير هيك يكون ارقام واحرف
            'nat_id' => 'required_if:accepted,2|',
            'functional_cases' => 'required_if:accepted,2',

            'photo' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'logo' => ['sometimes', 'mimes:png,jpg,jpeg,PNG,JPG,JPEG'],
            'cv' => $lawyer_cv . 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'id_file' => $lawyer_id_file . '|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'company_licence_no' => [$check_type_required],
            'company_licences_file' => [$lawyer_company_lisences_file, 'mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf'],
            'company_name' => [$check_type_required2],
            'status' => 'required',
            'status_reason' => 'sometimes'


        ];


    }

    public function messages()
    {
        return [
            'fname.required_if' => 'حقل الاسم مطلوب',
            'sname.required_if' => 'حقل الاسم مطلوب',
            'fourthname.required_if' => 'حقل الاسم مطلوب',

            'phone.required_if' => 'حقل الجوال  مطلوب',
            'phone.unique' => 'حقل الجوال  موجود مسبقاً',
            'email.required_if' => 'حقل الايميل مطلوب ',
            'email.email' => '  ادخل ايميل بالشكل الصحيح ',
            'email.unique' => '  الايميل موجود بالفعل  ',
            'type.required_if' => 'حقل  النوع في جهة العمل  مطلوب',
            'company_lisences_no.required_if' => 'حقل   رقم التجاري   مطلوب',
            'company_lisences_file.required_if' => 'حقل   ملف الترخيص  مطلوب',
            'company_name.required_if' => 'حقل  اسم ومعلومات الجهة  مطلوب',
            'about.required_if' => 'حقل  تعريف مختصر  مطلوب',
            'birth_date.required_if' => 'تاريخ الميلاد  مطلوب  ',
            'gender.required_if' => ' حقل الجنس مطلوب',
            'nationality.required_if' => 'حقل الجنسية مطلوب',
            'country_id.required_if' => 'حقل الدولة مطلوب',
            'region.required_if' => 'حقل المنطقة مطلوب',
            'city.required_if' => 'حقل المدينة مطلوب',
            'lon.required_if' => 'حقل خط العرض مطلوب',
            'lat.required_if' => 'حقل خط الطول مطلوب',
            'identity_type.required_if' => 'حقل نوع الهوية مطلوب ',
            'nat_id.required_if' => 'حقل  رقم الهوية  مطلوب  ',
            'id_file.required_if' => '  حقل الهوية مطلوب',
            'id_file.mimes' => '  يجب ان تكون الصيغة png,jpg,jpeg,PNG,JPG,JPEG ',
            'id_file.max' => '  يجب ان تكون حجم الصورة لا يتعدى 8140',
            'general_specialty.required_if' => 'حقل التخصص العام مطلوب',
            'accurate_specialty.required_if' => 'حقل التخصص الدقيق مطلوب',
            'functional_cases.required_if' => 'حقل الحالة الوظيفية مطلوب',
            'degree.required_if' => 'حقل  الدرجة العلمية  مطلوب  ',
            'degree_certificate.required' => 'حقل  الشهادة العلمية مطلوب  ',
            'is_advisor.required_if' => ' حقل مضاف إلى هيئة المستشارين مطلوب',
            'advisor_cat_id.required_if' => ' حقل الهيئات الاستشارية مطلوب . عندما تكون قيمة المدخل في حقل  مضاف إلى هيئة المستشارين (نعم )',
            'show_in_advoisory_website.required_if' => ' حقل حالة الظهور في قائمة المستشارين المنضمين حديثا في الموقع ممطلوبة  . عندما تكون قيمة المدخل في حقل  مضاف إلى هيئة المستشارين (نعم )',
            'accepted.required_if' => ' حقل القبول مطلوب',
            'paid_status.required_if' => ' حقل حالة الدفع مطلوب',
            'office_request_status.required_if' => ' حقل حالة قبول طلب المكتب مطلوب',
            'office_request_from.required_if' => '  حقل طلب مكتب من تاريخ مطلوب عندما تكون قيمة المدخل في حقل  حالة قبول طلب المكتب (قبول)',
            'office_request_to.required_if' => '  حقل طلب مكتب الى تاريخ مطلوب عندما تكون قيمة المدخل في حقل  حالة قبول طلب المكتب (قبول)',
            'digital_guide_subscription.required_if' => ' حقل حالة الاشتراك في باقة احد باقات الدليل الرقمي مطلوب',
            'digital_guide_subscription_payment_status.required_if' => ' حقل حالة الاشتراك في باقة احد باقات الدليل الرقمي مطلوب',
            'digital_guide_subscription_from.required_if' => ' حقل من تاريخ مطلوب عندما تكون قيمة المدخل في حقل حالة الاشتراك في باقة احد باقات الدليل الرقمي (مشترك)',
            'digital_guide_subscription_to.required_if' => 'حقل الى تاريخ مطلوب عندما تكون قيمة المدخل في حقل حالة الاشتراك في باقة احد باقات الدليل الرقمي (مشترك)',
            'special.required_if' => ' حقل (  هل العضو مميز ؟) مطلوب',
            'logo.required_if' => 'حقل الشعار مطلوب',
            'logo.mimes' => ' يجب ان تكون الصيغة png,jpg,jpeg,PNG,JPG,JPEG ',

            'cv.required_if' => 'حقل السيرة الذاتية مطلوب',
            'cv.mimes' => ' يجب ان تكون الصيغة pdf ',





            'sections.required_if' => 'حقل المهن مطلوب',
            'district.required_if' => 'حقل الحي مطلوب',


            'lisences.required_if' => 'حقل  الترخيص في جهة العمل  مطلوب',

            'license_file.mimes' => 'حقل صورة الهوية يجب ان يكون في صيغة png jpg jpeg',
            'license_file.max' => 'حقل صورة الهوية يجب ان يكون في حجم 8140',
            'other_entity_name.required_if' => ' حقل اسم ومعلومات الجهة مطلوب عندما يكون نوع جهة العمل اخرى او جهة حكومية او هيئة',



            'other_city.required_if' => 'حقل مدينة اخرى مطلوب . عندما تكون قيمة المدخل في حقل المدينة (اخرى)',



            'other_degree.required_if' => 'حقل (اذكر الدرجات العلميه الاخرى هنا)  مطلوب . عندما تكون قيمة المدخل في حقل نوع الهوية (اخرى)   ',
            'licence_no.required_if' => 'حقل رقم الترخيص مطلوب . عندما تكون المهن المختارة في حقل المهن تحتاج الى ترخيص ',

            'photo.mimes' => '  يجب ان تكون الصيغة png,jpg,jpeg,PNG,JPG,JPEG ',
            'photo.max' => '  يجب ان تكون حجم الصورة لا يتعدى 8140',



            'show_at_digital_guide.required_if' => ' حقل حالة الظهور في الدليل الرقمي مطلوب',
            'has_licence_no.required_if' => ' حقل (لديك ترخيص ؟) مطلوب',
            'has_licence_no.in' => ' يجب ان يكون  حقل (لديك ترخيص ؟) نعم بسبب وجود مهنة مختارة تحتاج ترخيص ',

        ]; // TODO: Change the autogenerated stub
    }
}
