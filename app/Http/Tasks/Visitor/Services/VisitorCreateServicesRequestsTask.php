<?php

namespace App\Http\Tasks\Visitor\Services;

use App\Http\Requests\API\Client\Services\ClientCreateServicesRequestsRequest;
use App\Http\Requests\API\Visitor\Services\VisitorCreateServicesRequestsRequest;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesResource;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\Client\ClientRequest;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;

class VisitorCreateServicesRequestsTask extends BaseTask
{

    public function run(VisitorCreateServicesRequestsRequest $request)
    {
        $password = GenerateRegistrationRandomCode(6);
        $Service = Service::where('status', 1)->findOrFail($request->service_id);
        $client = ServiceUser::create([
            'myname' => $request->name,
            'mobil' => $request->mobile,
            'type' => $request->type,
            'email' => $request->email,
            'active' => 1,
            'activation_type' => 1,
            'password' => bcrypt($password),
        ]);
        $bodyMessage = 'مرحباً بك عميلنا العزيز , اليك بيانات الدخول الى حسابك لمتابعة طلباتك ,';
        $bodyMessage1 = 'الايميل : ' . ' ' . $client->email;
        $bodyMessage2 = 'كلمة المرور : ' . ' ' . $password;
        $bodyMessage3 = 'رابط الدخول :  ' . ' ' . env('REACT_WEB_LINK') . "/auth/signin";
        $bodyMessage4 = 'لتسجيل الدخول ';
        $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage6 = 'لاستعادة كلمة المرور :';
        // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
        $bodyMessage6 = "";
        $bodyMessage7 = "";
        $bodyMessage8 = 'للتواصل والدعم الفني :';
        $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage10 = 'نعتز بثقتكم';
        $data = [
            'name' => $client->myname,
            'email' => ($client->email),
            'subject' => " بيانات الدخول على حسابك في منصة يمتاز ",
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
        $service_request = ClientRequest::create([
            'client_id' => $client->id,
            'type_id' => $request->service_id,
            'priority' => $request->priority,
            'description' => $request->description,
            'for_admin' => 1,
            'payment_status' => 1,
            'price' => $Service->ymtaz_price,
            'accept_rules' => $Service->accept_rules,
        ]);
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request');
            $service_request->file = $file;
            $service_request->update();
        }

        $service_request = new ClientRequestResource($service_request);
        return $this->sendResponse(true, ' تم ارسال طلب الخدمة بنجاح , ونرجو مراجعة بريدك الالكتروني لمتابعة بيانات الدخول حتى تتمكن من متابعة طلباتك والاستمتاع بخدمات يمتاز ', compact('service_request'), 200);
    }
}
