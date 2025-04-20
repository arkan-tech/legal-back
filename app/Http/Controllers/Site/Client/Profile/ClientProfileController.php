<?php

namespace App\Http\Controllers\Site\Client\Profile;

use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Illuminate\Validation\Rule;
use App\Models\Country\Nationality;
use App\Models\Service\ServiceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Client\ClientDeleteAccountRequest;
use App\Models\Lawyer\LawyerDeleteAccountRequest;
use App\Models\Lawyer\LawyerFirstStepVerefication;
use App\Http\Requests\Site\Client\Auth\ClientUpdateProfileRequest;

class ClientProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $client = auth()->guard('client')->user();
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        $cities = City::where('country_id', $countries->first()->id)->where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('site.client.profile.profile', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {

        $client = ServiceUser::findOrFail($id);
        $nationalities = Nationality::where('status', 1)->get();
        $countries = Country::where('status', 1)->get();
        $regions = Regions::where('country_id', $countries->first()->id)->where('status', 1)->get();
        $cities = City::where('region_id', $regions->first()->id)->where('country_id', $countries->first()->id)->where('status', 1)->get();
        return view('site.client.profile.edit', get_defined_vars());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ClientUpdateProfileRequest $request)
    {
        $phone = $request->phone_code . $request->mobile;
        $check = ServiceUser::where('id', '<>', $request->id)->where('mobil', $phone)->first();
        if (!is_null($check)) {
            return response()->json([
                'status' => false,
                'msg' => ' ' . 'رقم الجوال ' . $phone . 'موجود مسبقاً '
            ]);
        }

        $key = GenerateRegistrationRandomCode(6);
        $client = ServiceUser::where('id', $request->id)->first();

        $client->update([
            'myname' => $request->myname,
            'phone_code' => $request->phone_code,
            'mobil' => $phone,
            'type' => $request->type,
            'email' => $request->email,
            'active' => 0,
            'status' => 1,
            'nationality_id' => $request->nationality_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city,
            'region_id' => $request->region_id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'gender' => $request->gender,
            'accepted' => 1,
            'active_otp' => $key,
        ]);
        if (!is_null($request->password)) {
            $client->update([
                'password' => bcrypt($request->password),
            ]);
        }

        $activation_type = 1;
        if ($request->phone_code == 966) {
            $activation_type = 2;
        }
        if ($activation_type == 1) {
            $link = route('site.client.show.activate.form', [$client->email, $key]);
            $bodyMessage3 = '';
            $bodyMessage4 = '';
            $bodyMessage5 = '';
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
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
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
            $route = route('site.client.show.login.form');
        } else {
            $msg = 'تم ارسال كود التفعيل على SMS , نرجو مراجعة هاتفك حتي يمكنك تفعيل حسابك ,';
            $route = route('site.client.sms.show.activate.form');
        }
        Auth::guard('client')->logout();
        return response()->json([
            'status' => true,
            'msg' => $msg,
            'route' => $route
        ]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    public function ClientDeleteAccount()
    {
        $lawyer = auth()->guard('lawyer')->user();
        return view('site.client.profile.delete_account', get_defined_vars());
    }
    public function SaveClientDeleteAccount(Request $request)
    {
        $request->validate([
            'delete_reason' => 'required',
            'development_proposal' => 'sometimes',
        ], [
            'delete_reason.required' => 'بالرجا ادخال سبب الحذف '
        ]);
        $requests = ClientDeleteAccountRequest::where('client_id', $request->client_id)->first();
        if (!is_null($requests)) {
            return \response()->json([
                'status' => true,
                'msg' => 'طلبك قيد المراجعة'
            ]);
        } else {
            ClientDeleteAccountRequest::create([
                'client_id' => $request->client_id,
                'delete_reason' => $request->delete_reason,
                'development_proposal' => $request->development_proposal,
                'status' => 0,
            ]);
            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' ' . ' تم استلام طلبكم بنجاح وسيتم اطلاعكم على حالة طلب حذف الحساب خلال 48 ساعة ';
            $bodyMessage2 = '';
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
            $data = [
                'name' => auth()->guard('client')->user()->myname,
                'email' => auth()->guard('client')->user()->email,
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
