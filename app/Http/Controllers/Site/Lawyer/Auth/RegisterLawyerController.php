<?php

namespace App\Http\Controllers\Site\Lawyer\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Lawyer\Auth\RegisterSiteRequest;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Districts\Districts;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Models\Lawyer\LawyerSections;
use App\Models\Regions\Regions;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\Specialty\GeneralSpecialty;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;

class RegisterLawyerController extends Controller
{

    public function showRegisterForm()
    {
        $countries = Country::where('status', 1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $regions = [];
        $cities = [];
        $districts = [];
        $general_specialties = GeneralSpecialty::where('status', 1)->get();
        $accurate_specialties = AccurateSpecialty::where('status', 1)->get();
        $functional_cases = FunctionalCases::where('status', 1)->get();
        return view('site.lawyers.auth.register', get_defined_vars());
    }

    public function ShowActivateForm($email, $otp)
    {

        $item = Lawyer::where('email', $email)->where('activate_email_otp', $otp)->first();
        if (is_null($item)) {
            return view('site.lawyers.auth.activate_fail');
        } else {
            $item->update([
                'activate_email_otp' => null,
                'activate_email' => 1,

            ]);
        }
        return view('site.lawyers.auth.activate_success');
    }


    public function saveRegisterData(RegisterSiteRequest $request)
    {

        $phone = $request->phone_code . $request->phone;
        $check = Lawyer::where('phone', $phone)->first();
        if (!is_null($check)) {
            return response()->json([
                'status' => false,
                'msg' => ' ' . 'رقم الجوال ' . $phone . 'موجود مسبقاً '
            ]);
        }

        $degree_certificate_check = true;
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                $item = DigitalGuideCategories::where('status', 1)->where('id', $section['sections'])->first();
                if ($item->need_license == 1) {
                    if (is_null($section['licence_no'])) {
                        return response()->json([
                            'status' => false,
                            'msg' => ' ' . 'المهنة : ' . '(' . $item->title . ')' . ' تحتاج إلى رقم ترخيص , يرجى المراجعة جيداً  '
                        ]);
                    }

                    if (!array_key_exists('licence_file', $section)) {
                        return response()->json([
                            'status' => false,
                            'msg' => ' ' . 'المهنة : ' . '(' . $item->title . ')' . ' تحتاج إلى ملف الترخيص , يرجى المراجعة جيداً  '
                        ]);
                    }
                    $degree_certificate_check = false;

                }

            }
        }

        if ($degree_certificate_check) {
            if (!array_key_exists('degree_certificate', $request->all())) {
                return response()->json([
                    'status' => false,
                    'msg' => 'يرجى ادخال الشهادة العلمية '
                ]);
            }
        }


        $lawyer_name = $request->fname . ' ' . $request->sname . ' ' . $request->tname . ' ' . $request->fourthname;
        $day = strlen($request->day) == 1 ? '0' . $request->day : $request->day;
        $birthday = $request->year . '-' . $request->month . '-' . $day;

        $lawyer = Lawyer::create([
            'name' => $lawyer_name,
            'first_name' => $request->fname,
            'second_name' => $request->sname,
            'third_name' => $request->tname,
            'fourth_name' => $request->fourthname,
            'username' => $lawyer_name,
            'city' => $request->city,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender,
            'degree' => $request->degree,
            'phone_code' => $request->phone_code,
            'phone' => $phone,
            'about' => $request->about,
            'nat_id' => $request->nat_id,
            'country_id' => $request->country_id,
            'type' => $request->type,
            'latitude' => $request->lat,
            'longitude' => $request->lon,
            'nationality' => $request->nationality,
            'day' => $day,
            'month' => $request->month,
            'year' => $request->year,
            'birthday' => $birthday,
            'company_name' => $request->company_name,
            'company_lisences_no' => $request->company_lisences_no,
            'region' => $request->region,
            'identity_type' => $request->identity_type,
            'general_specialty' => $request->general_specialty,
            'accurate_specialty' => $request->accurate_specialty,
            'functional_cases' => $request->functional_cases,

            'accept_rules' => $request->rules == 'on' ? 1 : 0,
            'paid_status' => 0,
            'is_advisor' => 0,
            'accepted' => 1,
            'special' => 0,
            'digital_guide_subscription' => 0,
            'office_request' => 0,
            'show_at_digital_guide' => 0,
            'profile_complete' => 0,
            'activate_email' => 0,
        ]);


        if ($request->has('personal_image')) {
            $lawyer->update(['photo' => saveImage($request->file('personal_image'), 'uploads/lawyers/personal_image/')]);
        }
        if ($request->has('degree_certificate')) {
            $lawyer->update(['degree_certificate' => saveImage($request->file('degree_certificate'), 'uploads/lawyers/degree_certificate/')]);
        }
        if ($request->has('company_lisences_file')) {
            $lawyer->update(['company_lisences_file' => saveImage($request->file('company_lisences_file'), 'uploads/lawyers/company_lisences_file/')]);
        }
        if ($request->has('logo')) {
            $lawyer->update(['logo' => saveImage($request->file('logo'), 'uploads/lawyers/logo/')]);

        }
        if ($request->has('id_file')) {
            $lawyer->update(['id_file' => saveImage($request->file('id_file'), 'uploads/lawyers/id_file/')]);
        }
        if ($request->has('cv')) {
            $lawyer->update(['cv' => saveImage($request->file('cv'), 'uploads/lawyers/cv/')]);
        }
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                $item = LawyerSections::create([
                    'lawyer_id' => $lawyer->id,
                    'section_id' => $section['sections'],
                    'licence_no' => $section['licence_no'],
                ]);
                if (array_key_exists('licence_file', $section)) {
                    $item->update([
                        'licence_file' => saveImage($section['licence_file'], 'uploads/lawyers/license_file/')
                    ]);
                }
            }
            $lawyer->update([
                'has_licence_no' => 1
            ]);
        }


        if ($lawyer->phone_code == 966) {
            $key = GenerateRegistrationRandomCode(6);
            LawyerFirstStepVerefication::create([
                'email' => $request->email,
                'phone_code' => $request->phone_code,
                'phone' => $lawyer->phone,
                'otp' => $key,
            ]);
            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
            $destinations = $lawyer->phone; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
            $message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
            $message = urlencode($message);
            $sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
            $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender";
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(),
                )
            );
            $response = curl_exec($curl);
            curl_close($curl);
            $msg = 'تم استلام بياناتك بنجاح , نعلمكم انه تم سيتم توجيهك ل رابط التحقق من رقم الجوال   ';
            $route = route('site.lawyer.show.activate.sms.form', [$lawyer->email, $lawyer->phone_code, $lawyer->phone]);

        } else {
            $activate_email_otp = GenerateRegistrationRandomCode(6);

            $lawyer->update([
                'activate_email_otp' => $activate_email_otp
            ]);
            $bodyMessage4 = '';
            $bodyMessage5 = 'لاستعادة كلمة المرور :';
            $bodyMessage5 = "";
            $bodyMessage6 = '';
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $em_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => " رابط تأكيد البريد. ",
                'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل . ",
                'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                'bodyMessage3' => route('site.lawyer.show.activate.form', [$lawyer->email, $activate_email_otp]),
                'bodyMessage4' => $bodyMessage4,
                'bodyMessage5' => $bodyMessage5,
                'bodyMessage6' => $bodyMessage6,
                'bodyMessage7' => $bodyMessage7,
                'bodyMessage8' => $bodyMessage8,
                'bodyMessage9' => $bodyMessage9,
                'bodyMessage10' => $bodyMessage10,
                'platformLink' => env('REACT_WEB_LINK'),

            ];
            Mail::send(
                'email',
                $em_data,
                function ($message) use ($em_data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                }
            );

            $msg = 'تم استلام بياناتك بنجاح , نعلمكم انه تم ارسال لكم ايميل لتفعيل حسابكم , يرجى مراجعة البريد الاكتروني :  ' . $lawyer->email;
            $route = env('REACT_WEB_LINK') . "/auth/signin";
        }

        return response()->json(
            [
                'status' => true,
                'msg' => $msg,
                'route' => $route,
            ]
        );

    }


    public function getRegionsBaseCountryId($id)
    {
        $regions = Regions::where('country_id', $id)->where('status', 1)->get();
        $items_html = view('site.lawyers.includes.region-select', compact('regions'))->render();
        $first_region = Regions::where('country_id', $id)->where('status', 1)->first();
        if (!is_null($first_region)) {
            $first_city = City::where('region_id', $first_region->id)->where('status', 1)->first();

        } else {
            $first_city = null;
        }

        return response()->json([
            'status' => true,
            'items_html' => $items_html,
            'first_region' => $first_region,
            'first_city' => $first_city
        ]);
    }

    public function getCitiesBaseRegionId($id)
    {
        $cities = City::where('region_id', $id)->where('status', 1)->get();
        $items_html = view('site.lawyers.includes.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function getDistrictsBaseCityId($id)
    {
        $districts = Districts::where('city_id', $id)->where('status', 1)->get();
        $items_html = view('site.lawyers.includes.districts-select', compact('districts'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    protected function guard()
    {
        return Auth::guard('lawyer');
    }

    public function CheckDegree($id)
    {
        $degree = Degree::findOrFail($id);
        return response()->json([
            'status' => true,
            'degree' => $degree
        ]);
    }

    public function CheckSection($id)
    {
        $section = DigitalGuideCategories::findOrFail($id);
        return response()->json([
            'status' => true,
            'section' => $section
        ]);
    }

    public function ShowActivateSMSForm($email, $phone_code, $phone)
    {
        return view('site.lawyers.auth.activate_sms_account_form', get_defined_vars());
    }

    public function PostActivateSMS(Request $request)
    {
        $check = LawyerFirstStepVerefication::where('email', $request->email)->where('phone_code', $request->phone_code)->where('phone', $request->phone)->wherE('otp', $request->otp)->first();
        if (is_null($check)) {
            return response()->json([
                'status' => false,
                'msg' => 'الرمز خطأ',
                'title' => 'error',
            ]);
        }
        $check->delete();
        $lawyer = Lawyer::where('email', $request->email)->first();

        $activate_email_otp = GenerateRegistrationRandomCode(6);

        $lawyer->update([
            'activate_email_otp' => $activate_email_otp
        ]);
        $bodyMessage4 = '';
        $bodyMessage5 = 'لاستعادة كلمة المرور :';
        $bodyMessage6 = '';
        $bodyMessage7 = 'للتواصل والدعم الفني :';
        $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage9 = '';
        $bodyMessage10 = 'نعتز بثقتكم';
        $em_data = [
            'name' => $lawyer->name,
            'email' => $lawyer->email,
            'subject' => "رابط تأكيد البريد . ",
            'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
            'bodyMessage3' => route('site.lawyer.show.activate.form', [$lawyer->email, $activate_email_otp]),
            'bodyMessage4' => $bodyMessage4,
            'bodyMessage5' => $bodyMessage5,
            'bodyMessage6' => $bodyMessage6,
            'bodyMessage7' => $bodyMessage7,
            'bodyMessage8' => $bodyMessage8,
            'bodyMessage9' => $bodyMessage9,
            'bodyMessage10' => $bodyMessage10,
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        Mail::send(
            'email',
            $em_data,
            function ($message) use ($em_data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
            }
        );

        return response()->json(
            [
                'status' => true,
                'msg' => 'تم استلام بياناتك بنجاح , نعلمكم انه تم ارسال لكم ايميل لتفعيل حسابكم , يرجى مراجعة البريد الاكتروني :  ' . $lawyer->email,
                'title' => 'success',
            ]
        );

    }

}
