<?php

namespace App\Http\Controllers\NewAdmin;

use id;
use Inertia\Inertia;
use App\Models\AccountFcm;
use App\Models\ContactYmtaz;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Devices\LawyerFcmDevice;
use App\Http\Controllers\PushNotificationController;


class ContactUsRequestsController extends Controller
{
    private $ContactTypes = [
        [
            "id" => 1,
            "name" => "اقتراح"
        ],
        [
            "id" => 2,
            "name" => "شكوى"
        ],
        [
            "id" => 3,
            "name" => "اخرى"
        ]
    ];
    public function index()
    {
        $requests = ContactYmtaz::with(['account'])->get();
        $types = $this->ContactTypes;
        return Inertia::render("ContactUsRequests/index", get_defined_vars());
    }

    public function show($id)
    {
        $request = ContactYmtaz::with(['account', 'user'])->findOrFail($id);
        $types = $this->ContactTypes;
        return Inertia::render("ContactUsRequests/Edit/index", get_defined_vars());

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "reply_subject" => "required",
            "reply_description" => "required",
        ], ["*" => "الحقل مطلوب"]);

        $contactRequest = ContactYmtaz::with(['account', 'user'])->findOrFail($id);

        $contactRequest->update([
            "reply_subject" => $request->reply_subject,
            "reply_description" => $request->reply_description,
            "reply_user_id" => auth()->user()->id
        ]);
        if (!is_null($contactRequest->account_id)) {
            $fcms = AccountFcm::where("account_id", $contactRequest->account_id)->get()->pluck("fcm_token")->toArray();
            Notification::create([
                'title' => "رد الشكوى",
                "description" => "تم الرد على شكوتكم",
                "type" => "contact-us-request",
                "type_id" => $contactRequest->id,
                "account_id" => $contactRequest->account_id
            ]);
            if (count($fcms) > 0) {

                $notificationController = new PushNotificationController;
                $notificationController->sendNotification($fcms, "رد الشكوى", "تم الرد على شكوتكم", ["type" => "contact-us-request", "type_id" => $contactRequest->id]);
            }
        } else {
            $bodyMessage4 = '';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $em_data = [
                'name' => $contactRequest->name,
                'email' => $contactRequest->email,
                'subject' => "رد على طلبكم",
                'bodyMessage' => "عزيزي العميل:",
                'bodyMessage1' => "تم الرد على طلبكم و يمكنك ان تجد الرد في الأسفل:",
                'bodyMessage2' => "نوع الطلب: " . $this->ContactTypes[$contactRequest->type - 1],
                'bodyMessage3' => 'الطلب: ' . $contactRequest->subject,
                'bodyMessage4' => "الرد: " . $request->reply_description,
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
        }
        $contactRequest = ContactYmtaz::with(['account', 'user'])->findOrFail($id);

        return response()->json([
            "status" => true,
            "data" => $contactRequest
        ]);
    }
}
