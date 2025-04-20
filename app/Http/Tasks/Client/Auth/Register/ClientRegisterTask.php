<?php

namespace App\Http\Tasks\Client\Auth\Register;

use App\Models\Account;
use Mail;
use App\Models\Activity;
use App\Models\LawyerOld;
use App\Models\Newsletter;
use App\Http\Tasks\BaseTask;
use App\Models\ReferralCode;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Service\ServiceUser;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Requests\API\Client\Auth\Register\ClientRegisterRequest;

class ClientRegisterTask extends BaseTask
{
    public function run(ClientRegisterRequest $request)
    {

        $key = GenerateRegistrationRandomCode(6);
        $referralCode = GenerateReferralCode();
        $client = ServiceUser::create([
            'myname' => $request->name,
            'phone_code' => $request->phone_code,
            'mobil' => $request->mobile,
            'type' => $request->type,
            'email' => $request->email,
            'active' => 0,
            'status' => 1,
            'activation_type' => $request->activation_type,
            'nationality_id' => $request->nationality_id,
            'country_id' => $request->country_id,
            'city_id' => $request->city_id,
            'region_id' => $request->region_id,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'gender' => $request->gender,
            'accepted' => 1,
            'active_otp' => $key,
            'password' => bcrypt($request->password),
            'referred_by' => $request->referred_by,
            'level_id' => 1,
            'rank_id' => 1,

        ]);


            $client2 = Account::create([
                'id' => $client->id,
                'name' => $request->name,
                'phone_code' => $request->phone_code,
                'phone' => $request->mobile,
                'type' => $request->type,
                'email' => $request->email,
                'account_type' => 'client',
                // 'active' => 0,
                'status' => 1,
                // 'activation_type' => $request->activation_type,
                'nationality_id' => $request->nationality_id,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'region_id' => $request->region_id,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'gender' => $request->gender,
                // 'accepted' => 1,
                'phone_otp' => $key,
                'password' => bcrypt($request->password),
                // 'referred_by' => $request->referred_by,
                // 'level_id' => 1,
                // 'rank_id' => 1,

            ]);


        // $exists = Account::find($client->id);
        // if ($exists) {
        //     dd('Already exists',$client2 ->id);
        // }else{

        //     dd('فشل الحفظ');
        // }

        // dd($client->id,$client2->id);

        $oldUser = ServiceUserOld::where('email', $request->email)->orWhere(['mobil' => $request->mobile, 'phone_code' => $request->phone_code])->first();
        if (!is_null($oldUser)) {
            if ($oldUser->accepted == 0) {
                $oldUser->update([
                    'accepted' => 1
                ]);
            }
        } else {
            $oldUser = LawyerOld::where('email', $request->email)->orWhere(['phone' => $request->mobile, 'phone_code' => $request->phone_code])->first();
            if (!is_null($oldUser)) {
                if ($oldUser->accepted == 0) {
                    $oldUser->update([
                        'accepted' => 1
                    ]);
                }
            }
        }
        if (!is_null($request->referred_by)) {
            $referral = ReferralCode::where('referral_code', $request->referred_by)->first();
            if (!is_null($referral)) {
                $referralUser = $referral->user();
                $activity = Activity::find(5);
                $referralUser->addExperience($activity->experience_points, $activity->name, $activity->notification);
            }
        }

        $clientrc = new ClientDataResource($client);



        if ($request->activation_type == 1) {
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
                'subject' => " كود تفعيل الحساب . ",
                'bodyMessage' => "مرحباً بك في تطبيق يمتاز , كود التفعيل الذي يمكنك تفعيل حسابك حتى تستمتع بخدمات التطبيق : ",
                'bodyMessage1' => $key,
                'bodyMessage2' => " ",
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
            // Mail::send(
            //     'email',
            //     $em_data,
            //     function ($message) use ($em_data) {
            //         $message->from('ymtaz@ymtaz.sa');
            //         $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
            //     }
            // );
        } else {
            $username = "Ymtaz.sa";            // اسم المستخدم الخاص بك في الموقع
            $password = urlencode("Ymtaz@132@132@132");        // كلمة المرور الخاصة بك
            $destinations = $client->mobil; //الارقام المرسل لها  ,, يتم وضع فاصلة بين الارقام المراد الارسال لها
            $message = 'كود تفعيل الحساب : ' . ' ' . $key;      // محتوى الرسالة
            $message = urlencode($message);
            $sender = "Ymtaz.sa";         // اسم المرسل الخاص بك المفعل  في الموقع
            $url = "http://www.jawalbsms.ws/api.php/sendsms?user=$username&pass=$password&to=$destinations&message=$message&sender=$sender&unicode=u";
            \Illuminate\Support\Facades\Log::info($url);
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
            \Illuminate\Support\Facades\Log::info($response);
            curl_close($curl);
        }


        $msg = '';
        if ($request->activation_type == 1) {
            $msg = 'تم ارسال كود التفعيل على الايميل , نرجو مراجعة الايميل حتي يمكنك تفعيل حسابك ,';
        } else {
            $msg = 'تم ارسال كود التفعيل على SMS , نرجو مراجعة هاتفك حتي يمكنك تفعيل حسابك ,';
        }
        $activity = Activity::find(9);
        // $client->addExperience($activity->experience_points, $activity->name, $activity->notification);
        $client->referralCode()->create([
            'referral_code' => $referralCode,
            'account_id' => $client->id,
        ]);
        // $newsletter = Newsletter::where('email', $request->email);
        // if (is_null($newsletter)) {
        //     Newsletter::create([
        //         "email" => $request->email
        //     ]);
        // }
        return $this->sendResponse(true, $msg, compact('client'), 200);
    }

}
