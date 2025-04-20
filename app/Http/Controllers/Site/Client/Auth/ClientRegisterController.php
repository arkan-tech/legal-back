<?php

namespace App\Http\Controllers\Site\Client\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Client\Auth\ClientAuthRegisterRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Country\Nationality;
use App\Models\Districts\Districts;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Models\Regions\Regions;
use App\Models\Service\ServiceUser;
use File;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Mail;

class ClientRegisterController extends Controller
{
    use AuthenticatesUsers;

    public function showRegisterForm()
    {
        $countries = Country::where('status', 1)->get();
        $nationalities = Nationality::where('status', 1)->get();
        $cities = [];
        $regions = [];
        return view('site.client.auth.register', get_defined_vars());
    }

    public function saveRegisterData(ClientAuthRegisterRequest $request)
    {
        $key = GenerateRegistrationRandomCode(6);
        $client = ServiceUser::create([
            'myname' => $request->name,
            'gender' => $request->gender,
            'password' => bcrypt($request->password),
            'phone_code' => $request->phone_code,
            'mobil' => $request->phone_code . $request->mobile,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'city_id' => $request->city,
            'nationality_id' => $request->nationality_id,
            'email' => $request->email,
            'username' => $request->email,
            'accept_rules' => $request->rules == 'on' ? '1' : 0,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'active' => 0,
            'status' => 1,
            'active_otp' => $key,
        ]);


        $activation_type = 1;
        if ($request->phone_code == 966) {
            $activation_type = 2;
        }
        if ($activation_type == 1) {
            $link = route('site.client.show.activate.form', [$client->email, $key]);
            $bodyMessage3 = '';
            $bodyMessage4 = '';
            $bodyMessage5 = ' ';
            $bodyMessage6 = '';
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $em_data = [
                'name' => $client->myname,
                'email' => $client->email,
                'subject' => " رابط تأكيد البريد . ",
                'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز . ",
                'bodyMessage1' => 'يرجى اتباع الرابط التالي : ',
                'bodyMessage2' => $link,
                'bodyMessage3' => " ",
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
        } else {
            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");       // كلمة المرور الخاصة بك
            $destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
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
        }


        if ($activation_type == 1) {
            $msg = 'تم ارسال رابط التفعيل على الايميل , نرجو مراجعة الايميل حتي يمكنك تفعيل حسابك ,';
            $route = env('REACT_WEB_LINK') . "/auth/signin";
        } else {
            $msg = 'تم ارسال كود التفعيل على SMS , نرجو مراجعة هاتفك حتي يمكنك تفعيل حسابك ,';
            $route = route('site.client.sms.show.activate.form');
        }
        return response()->json([
            'status' => true,
            'msg' => $msg,
            'route' => $route
        ]);

    }

    public function getCitiesBaseRegionId($id)
    {
        $cities = City::where('region_id', $id)->where('status', 1)->orderBy('created_at', 'desc')->get();
        $items_html = view('site.lawyers.includes.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function ClientActivateAccount($email, $otp)
    {

        $item = ServiceUser::where('email', $email)->where('active_otp', $otp)->first();
        if (is_null($item)) {
            return view('site.lawyers.auth.activate_fail');
        } else {
            $item->update([
                'active' => 1,
                'accepted' => 2,
                'active_otp' => null,
            ]);
        }
        return view('site.lawyers.auth.activate_success');
    }

    public function ShowActivateAccountForm()
    {

        return view('site.client.auth.activate_account_form');
    }

    public function PostActivateAccountForm(Request $request)
    {

        $item = ServiceUser::where('active_otp', $request->otp)->where('active', 0)->first();
        if (is_null($item)) {
            return response()->json([
                'status' => false,
                'msg' => 'عذراً , هناك خطأ في  الرمز ',
                'title' => 'error',
            ]);
        } else {

            if ($item->phone_code == 966) {
                $key = GenerateRegistrationRandomCode(6);
                $link = route('site.client.show.activate.form', [$item->email, $key]);
                $bodyMessage3 = '';
                $bodyMessage4 = '';
                $bodyMessage5 = '';
                $bodyMessage6 = '';
                $bodyMessage7 = 'للتواصل والدعم الفني :';
                $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
                $bodyMessage9 = '';
                $bodyMessage10 = 'نعتز بثقتكم';
                $em_data = [
                    'name' => $item->myname,
                    'email' => $item->email,
                    'subject' => "رابط تأكيد البريد  . ",
                    'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز . ",
                    'bodyMessage1' => 'يرجى اتباع الرابط التالي : ',
                    'bodyMessage2' => $link,
                    'bodyMessage3' => " ",
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
                $item->update([
                    'active_otp' => $key,
                ]);
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تفعيل الرقم بنجاح
نأمل منكم تأكيد التفعيل بالضغط على الرابط المرسل لكم على بريدكم الإلكتروني المسجل لدينا
',
                    'title' => 'success',
                ]);
            } else {

                $item->update([
                    'active' => 1,
                    'active_otp' => null,
                ]);
                return response()->json([
                    'status' => true,
                    'msg' => 'تم تفعيل الحساب بنجاح ',
                    'title' => 'success',
                ]);
            }


        }

    }

    public function getRegionsBaseCountryId($id)
    {
        $regions = Regions::where('country_id', $id)->get();
        $first_region = Regions::where('country_id', $id)->where('status', 1)->first();
        if (!is_null($first_region)) {
            $first_city = City::where('region_id', $first_region->id)->where('status', 1)->first();

        } else {
            $first_city = null;
        }

        $items_html = view('site.client.includes.region-select', compact('regions'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html,
            'first_region' => $first_region,
        ]);
    }

    public function getCitiesBaseRegionId2($id)
    {
        $cities = City::where('region_id', $id)->get();
        $items_html = view('site.client.includes.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }



    public function ShowActivateSMSForm($email, $phone_code, $phone)
    {
        return view('site.client.auth.activate_sms_account_form', get_defined_vars());
    }

    public function PostActivateSMSPostActivateSMS(Request $request)
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
        $client = ServiceUser::where('email', $request->email)->first();

        $activate_email_otp = GenerateRegistrationRandomCode(6);
        $client->update([
            'active_otp' => $activate_email_otp
        ]);
        $bodyMessage3 = 'لتسجيل الدخول ';
        $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage5 = 'لاستعادة كلمة المرور :';
        // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
        $bodyMessage5 = "";
        $bodyMessage6 = "";
        $bodyMessage7 = 'للتواصل والدعم الفني :';
        $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage9 = '';
        $bodyMessage10 = 'نعتز بثقتكم';
        $em_data = [
            'name' => $client->myname,
            'email' => $client->email,
            'subject' => " رابط تأكيد البريد. ",
            'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل . ",
            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
            'bodyMessage3' => route('site.client.show.activate.form', [$client->email, $activate_email_otp]),
            'bodyMessage4' => 'لتسجيل الدخول ',
            'bodyMessage5' => env('REACT_WEB_LINK') . "/auth/signin",
            // 'bodyMessage6' => 'لاستعادة كلمة المرور :',
            // 'bodyMessage7' => env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client",
            'bodyMessage6' => "",
            'bodyMessage7' => "",
            'bodyMessage8' => 'للتواصل والدعم الفني :',
            'bodyMessage9' => env('REACT_WEB_LINK') . "/contact-us",
            'bodyMessage10' => 'نعتز بثقتكم',
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
                'msg' => 'تم استلام بياناتك بنجاح , نعلمكم انه تم ارسال لكم ايميل لتفعيل حسابكم , يرجى مراجعة البريد الاكتروني :  ' . $client->email,
                'title' => 'success',
            ]
        );

    }

}
