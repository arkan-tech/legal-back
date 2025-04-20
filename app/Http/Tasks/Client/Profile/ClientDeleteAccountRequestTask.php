<?php

namespace App\Http\Tasks\Client\Profile;

use App\Http\Requests\API\Client\Profile\ClientDeleteAccountRequestRequest;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Tasks\BaseTask;
use App\Models\Client\ClientDeleteAccountRequest;
use Illuminate\Support\Facades\Mail;

class ClientDeleteAccountRequestTask extends BaseTask
{

    public function run(ClientDeleteAccountRequestRequest $request)
    {
        $client = $this->authClient();
        $requests = ClientDeleteAccountRequest::where('client_id', $client->id)->first();
        if (!is_null($requests)) {
            return $this->sendResponse(true, 'طلبك قيد المراجعة', null, 200);
        } else {


            ClientDeleteAccountRequest::create([
                'client_id' => $client->id,
                'delete_reason' => $request->delete_reason,
                'development_proposal' => $request->development_proposal,
                'status' => 0,
            ]);
            $bodyMessage = " مرحباً بك شريكنا  العزيز .  ";
            $bodyMessage1 = ' ' . ' تم استلام طلبكم بنجاح وسيتم اطلاعكم على حالة الطلب خلال 48 ساعة ';
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
                'name' => $client->myname,
                'email' => $client->email,
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
            return $this->sendResponse(true, 'تم تأكيد طلبك بنجاح وسيتم التواصل خلال 48 ساعة ', null, 200);
        }
    }
}
