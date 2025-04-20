<?php

namespace App\Http\Tasks\Lawyer\Profile;

use App\Http\Requests\API\Lawyer\Profile\LawyerDeleteAccountRequestRequest;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\LawyerDeleteAccountRequest;
use Illuminate\Support\Facades\Mail;

class LawyerDeleteAccountRequestTask extends BaseTask
{

    public function run(LawyerDeleteAccountRequestRequest $request)
    {
        $lawyer = $this->authLawyer();
        $requests = LawyerDeleteAccountRequest::where('lawyer_id', $lawyer->id)->first();
        if (!is_null($requests)) {
            return $this->sendResponse(true, 'طلبك قيد المراجعة', null, 200);
        } else {


            LawyerDeleteAccountRequest::create([
                'lawyer_id' => $lawyer->id,
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
            // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage5 = "";
            $bodyMessage6 = "";
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
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
