<?php

namespace App\Http\Controllers\Site\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Lawyer\Profile\updateRegisterSiteRequest;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\City\City;
use App\Models\Client\ClientLawyersMessage;
use App\Models\Country\Country;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Districts\Districts;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerDeleteAccountRequest;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Models\Lawyer\LawyerRates;
use App\Models\Lawyer\LawyerSections;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Package\Package;
use App\Models\Regions\Regions;
use App\Models\Service\ServicesRequest;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\Specialty\GeneralSpecialty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Support\Facades\Session;

class LawyerSiteController extends Controller
{

    protected function guard()
    {
        return Auth::guard('lawyer');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        if (is_numeric($id)) {
            $Lawyer = Lawyer::where('id', $id)->with('nationality_rel', 'country')->first();
            $photo = file_exists($Lawyer->photo) ? $Lawyer->photo : asset('uploads/person.png');
            $country = !is_null($Lawyer->country) ? $Lawyer->country->name : 'غير محدد';
            $nationality = !is_null($Lawyer->nationality_rel) ? $Lawyer->nationality_rel->name : 'غير محدد';
            if (Session::get('loggedInClientID') !== '') {
                $rating = LawyerRates::where('lawyer_id', $Lawyer->id)->first();
            } else {
                $rating = 0;
            }
            $lawyerServicesPrices = LawyersServicesPrice::where('lawyer_id', $Lawyer->id)->get();
            if ($Lawyer) {
                $Sections = json_decode($Lawyer->sections);
                $DigitalGuideCategories = DigitalGuideCategories::where('status', 1)->whereIn('id', $Sections)->get();
                return view('site.lawyers.lawyers', get_defined_vars());
            }
        }
    }


    public function lawyerReceivedEmails(Request $request)
    {
        $lawyer = Lawyer::where('id', auth()->guard('lawyer')->user()->id)->first();

        $emails = ClientLawyersMessage::where('lawyer_id', $lawyer->id)
            ->where('sender_type', 1)
            ->where('message_id', 0)->get();

        return view('site.lawyers.lawyerreceivedemails', compact('emails', 'lawyer'));
    }

    public function searchLaywers(Request $request)
    {
        $query = Lawyer::query();

        if ($request->section) {
            $query = $query->where('Sections', 'like', '%' . $request->section . '%');
        }

        if ($request->country) {
            $keyword = $request->country;
            $query = $query->where(function ($query) use ($keyword) {
                $query->where('country_id', '=', $keyword);
            });
        }

        if ($request->city) {
            $query = $query->where('City', $request->city);
        }

        $query = $query->where([['Accepted', '=', 1], ['digital_guide_subscription_payment_status', 1]]);

        $Lawyers = $query->get();
        return view('site.lawyers.search.searchlawyers', compact('Lawyers'));

    }

    public function viewLawyerMessage(Request $request)
    {
        $main_message = ClientLawyersMessage::where('id', $request->id)->first();

        $main_message->update(array('status' => 1));

        $lawyer = Lawyer::where('id', Session::get('loggedInUserID'))->first();

        $messages = ClientLawyersMessage::where('message_id', $request->id)->orderBy('id', 'ASC')->get();

        if ($messages) {
            foreach ($messages as $message) {
                $message->update(array('status' => 1));
            }
        }

        return view('site.lawyers.viewlawyermessage', compact('messages', 'main_message', 'lawyer'));
    }

    public function Profile()
    {


        $lawyer = auth()->guard('lawyer')->user();
        $nationality = Country::where('status', 1)->where('id', $lawyer->nationality)->first();
        $countries = Country::where('status', 1)->where('id', $lawyer->country_id)->first();
        $regions = Regions::where('status', 1)->where('id', $lawyer->region)->first();
        $cities = City::where('status', 1)->where('id', $lawyer->city)->first();
        if ($lawyer->accepted == 2) {
            $packages = Package::get();
            $digital_packages = DigitalGuidePackage::get();
            return view('site.lawyers.profile', get_defined_vars());

        } else {
            if ($lawyer->accepted == 1) {
                return redirect()->route('site.lawyer.show-em-login')->with('waiting-accept', $lawyer->id);

            } else if ($lawyer->accepted == 3) {
                return redirect()->route('site.lawyer.show-em-login')->with('waiting', $lawyer->id);
            } else {
                return redirect()->route('site.lawyer.show-em-login')->with('blocked', $lawyer->id);
            }

        }

    }

    public function EditProfile($id)
    {
        //        $id = decrypt($id);
        $lawyer = Lawyer::findOrFail($id);
        $lawyer_sections_ids = LawyerSections::where('lawyer_id', $id)->get()->pluck('section_id')->toArray();
        $countries = Country::where('status', 1)->get();
        $sections = DigitalGuideCategories::whereNotIn('id', $lawyer_sections_ids)->where('status', 1)->get();
        $regions = Regions::where('country_id', $lawyer->country_id)->get();
        $cities = City::where('region_id', $lawyer->region)->get();
        $districts = Districts::where('country_id', $lawyer->country_id)->where('region_id', $lawyer->region)->where('city_id', $lawyer->city)->get();
        $degrees = Degree::all();
        $general_specialties = GeneralSpecialty::where('status', 1)->get();
        $accurate_specialties = AccurateSpecialty::where('status', 1)->get();
        $functional_cases = FunctionalCases::where('status', 1)->get();
        $lawyer_sections = LawyerSections::where('lawyer_id', $id)->get();
        $degrees = Degree::where('status', 1)->get();
        return view('site.lawyers.profile.edit', get_defined_vars());
    }

    public function updateRegisterData(updateRegisterSiteRequest $request)
    {

        $lawyer = Lawyer::findOrFail($request->id);
        $phone = $request->phone_code . $request->phone;
        $check = Lawyer::where('id', '<>', $request->id)->where('phone', $phone)->first();
        if (!is_null($check)) {
            return response()->json([
                'status' => false,
                'msg' => ' ' . 'رقم الجوال ' . $phone . 'موجود مسبقاً '
            ]);
        }



        $degree_certificate_check = false;
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                if (!is_null($section['sections'])) {
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
        }

        if ($degree_certificate_check && $request->has('sections')) {
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

        $lawyer->update([
            'name' => $lawyer_name,
            'first_name' => $request->fname,
            'second_name' => $request->sname,
            'third_name' => $request->tname,
            'fourth_name' => $request->fourthname,
            'username' => $lawyer_name,
            'city' => $request->city,
            'email' => $request->email,
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
            'accepted' => 1,
            'activate_email' => 0,
        ]);


        if (!is_null($request['password'])) {
            $lawyer->update([
                'password' => bcrypt($request->password)
            ]);
        }

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
                $item = DigitalGuideCategories::where('id', $section['sections'])->first();
                if (!is_null($item)) {
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
                    $lawyer->update([
                        'has_licence_no' => 1
                    ]);
                }

            }

        }


        if ($lawyer->phone_code == 966) {
            $key = GenerateRegistrationRandomCode(6);
            LawyerFirstStepVerefication::create([
                'email' => $request->email,
                'phone_code' => $request->phone_code,
                'phone' => str_replace($lawyer->phone_code, '', $lawyer->phone),
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

            $route = route('site.lawyer.show.activate.sms.form', [$lawyer->email, $lawyer->phone_code, str_replace($lawyer->phone_code, '', $lawyer->phone)]);

        } else {
            $activate_email_otp = GenerateRegistrationRandomCode(6);

            $lawyer->update([
                'activate_email_otp' => $activate_email_otp
            ]);
            $bodyMessage4 = '';
            $bodyMessage5 = '';
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

        return response()->json([
            'status' => true,
            'msg' => $msg,
            'route' => $route,
        ]);
        //        return response()->json([
//            'status' => true,
//            'msg' => 'تم استلام بياناتك الجديدة بنجاح , و حسابك الآن ينتظر الاعتماد من قبل الإدارة.
//قد يستغرق هذا الاعتماد ٢٤ ساعة، كما ستصلك رسالة التفعيل على الايميل عند اعتماده . ,شكراً ل تفهمك  .',
//            'route' => env('REACT_WEB_LINK')."/auth/signin"]);
    }


    public function showPaymentRules(Request $request)
    {
        $packages = DigitalGuidePackage::where('status', 1)->get();
        $lawyer = \auth()->guard('lawyer')->user();
        return view('site.lawyers.PaymentRules.showpaymentrules', compact('packages', 'lawyer'));
    }

    public function lawyerServicesRequests(Request $request, $id)
    {
        $lawyer = Lawyer::where('id', $id)->first();
        $lawyer_requests = ServicesRequest::where('lawyer_id', $id)->get();
        return view('site.lawyers.services.services-requests', compact('lawyer_requests', 'lawyer'));
    }


    public function LawyerInformation()
    {
        $lawyer = \auth()->guard('lawyer')->user();
        $nationality = Country::where('status', 1)->where('id', $lawyer->nationality)->first();
        $countries = Country::where('status', 1)->where('id', $lawyer->country_id)->first();
        $regions = Regions::where('status', 1)->where('id', $lawyer->region)->first();
        $cities = City::where('status', 1)->where('id', $lawyer->city)->first();
        $degrees = Degree::all();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $advisories = AdvisoryCommittee::all();
        return view('site.lawyers.information.information', get_defined_vars());

    }

    public function LawyerDeleteAccount()
    {
        $lawyer = auth()->guard('lawyer')->user();
        return view('site.lawyers.profile.delete_account.delete_account', get_defined_vars());
    }
    public function SaveLawyerDeleteAccount(Request $request)
    {
        $request->validate([
            'delete_reason' => 'required',
            'development_proposal' => 'sometimes',
        ], [
            'delete_reason.required' => 'بالرجا ادخال سبب الحذف '
        ]);
        $requests = LawyerDeleteAccountRequest::where('lawyer_id', $request->lawyer_id)->first();
        if (!is_null($requests)) {
            return \response()->json([
                'status' => true,
                'msg' => 'طلبك قيد المراجعة'
            ]);
        } else {
            LawyerDeleteAccountRequest::create([
                'lawyer_id' => $request->lawyer_id,
                'delete_reason' => $request->delete_reason,
                'development_proposal' => $request->development_proposal,
                'status' => 0,
            ]);
            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' ' . ' تم استلام طلبكم بنجاح وسيتم اطلاعكم على حالة طلب حذف الحساب خلال 48 ساعة ';
            $bodyMessage2 = '';
            $bodyMessage3 = 'لتسجيل الدخول ';
            $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
            $bodyMessage5 = 'لاستعادة كلمة المرور :';
            $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => auth()->guard('lawyer')->user()->name,
                'email' => auth()->guard('lawyer')->user()->email,
                'subject' => " الرد على طلب حذف حساب في تطبيق يمتاز  . ",
                'bodyMessage' => $bodyMessage,
                'bodyMessage1' => $bodyMessage1,
                'bodyMessage2' => $bodyMessage2,
                'bodyMessage3' => $bodyMessage3,
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
                $data,
                function ($message) use ($data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($data['email'], $data['name'])->subject($data['subject']);
                }
            );
            return \response()->json([
                'status' => true,
                'msg' => 'تم تأكيد طلبك بنجاح وسيتم التواصل خلال 48 ساعة'
            ]);

        }
    }
}


