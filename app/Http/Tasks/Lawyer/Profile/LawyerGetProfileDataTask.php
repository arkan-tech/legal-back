<?php

namespace App\Http\Tasks\Lawyer\Profile;

use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Resources\API\Lawyer\LawyerWithServicesResource;
use Tymon\JWTAuth\Facades\JWTAuth;

class LawyerGetProfileDataTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = $this->authLawyer();




        $httpClient = new Client();
        $jsonData = [
            "userType" => "lawyer",
            "userId" => $lawyer->id
        ];
        $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
            'json' => $jsonData
        ]);
        $httpRequest->wait();





        $lawyerProfile = Lawyer::find($lawyer->id);
        $lawyerProfile->incrementStreak();
        $lawyer = new LawyerDataResource($lawyerProfile);
        $lawyer = array_merge($lawyer->toArray($request), [
            'streamio_id' => $lawyerProfile->streamio_id,
            'streamio_token' => $lawyerProfile->streamio_token,
            "accepted" => $lawyerProfile->accepted,
            "confirmationType" => $lawyerProfile->confirmationType
        ]);
        if ($lawyerProfile->accepted == 0) {
            return $this->sendResponse(false, "لقد تم تعليق حسابكم في يمتاز بناء على طلبكم أو لسبب قررته الإدارة المختصة.
يمكنك التواصل معنا في حال كان هذا التعليق خاطئاً أو غير مبرر.", null, 401);
        }
        if ($lawyerProfile->accepted == 1) {
            $msg = "  حسابكم الآن بمنصة يمتاز الإلكترونية في حالة قيد الدراسة والتفعيل، وسيصلكم الإشعار بتفعيل عضويتكم أو طلب تحديث بياناتكم قريبا.";
        }
        if ($lawyerProfile->accepted == 2) {
            $msg = "تهانينا ,لقد تم تفعيل حسابكم بمنصة يمتاز القانونية بنجاح.
    يمكنكم الآن الاطلاع على ملفكم الشخصي والتمتع بخصائص عضويتكم بكل يسر وسهولة.";
        }
        if ($lawyerProfile->accepted == 3) {
            $msg = "شريكنا العزيز:
يمكنك الآن تحديث بياناتك للحصول على مزايا العضوية التي تخولك الاستفادة من المزايا المجانية.";
        }
        return $this->sendResponse(true, $msg, compact('lawyer'), 200);
    }
}
