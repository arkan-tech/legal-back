<?php

namespace App\Http\Tasks\Client\Profile;

use App\Models\Service\ServiceUser;
use GuzzleHttp\Client;
use App\Http\Tasks\BaseTask;
use App\Http\Resources\API\Client\ClientDataResource;

class ClientGetUserProfileTask extends BaseTask
{

    public function run()
    {
        \Log::info('hello');

        $client = $this->authClient();
        $httpClient = new Client();
        $jsonData = [
            "userType" => "client",
            "userId" => $client->id
        ];
        $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/createToken', [
            'json' => $jsonData
        ]);
        $httpRequest->wait();
        $clientProfile = ServiceUser::find($client->id);
        $clientProfile->incrementStreak();
        \Log::info('Client Profile: ' . json_encode($clientProfile));

        $client = new ClientDataResource($clientProfile);
        if ($clientProfile->accepted == 0) {
            return $this->sendResponse(false, "لقد تم تعليق حسابكم في يمتاز بناء على طلبكم أو لسبب قررته الإدارة المختصة.
يمكنك التواصل معنا في حال كان هذا التعليق خاطئاً أو غير مبرر.", null, 403);
        }
        if ($clientProfile->accepted == 1) {
            $msg = "  حسابكم الآن بمنصة يمتاز الإلكترونية في حالة قيد الدراسة والتفعيل، وسيصلكم الإشعار بتفعيل عضويتكم أو طلب تحديث بياناتكم قريبا.";
        }
        if ($clientProfile->accepted == 2) {
            $msg = "تهانينا ,لقد تم تفعيل حسابكم بمنصة يمتاز القانونية بنجاح.
    يمكنكم الآن الاطلاع على ملفكم الشخصي والتمتع بخصائص عضويتكم بكل يسر وسهولة.";
        }
        if ($clientProfile->accepted == 3) {
            $msg = "شريكنا العزيز:
يمكنك الآن تحديث بياناتك للحصول على مزايا العضوية التي تخولك الاستفادة من المزايا المجانية.";
        }
        return $this->sendResponse(true, $msg, compact('client'), 200);
    }
}
