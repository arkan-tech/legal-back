<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Account;
use App\Models\Visitor;
use App\Models\AccountFcm;
use App\Models\VisitorFCM;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Controllers\PushNotificationController;


class NotificationController extends Controller
{
    public function index()
    {
        $clients = Account::whereNotNull("email")->where('account_type', "client")->select('id', 'name', 'email')->get();
        $lawyers = Account::whereNotNull("email")->where('account_type', "lawyer")
            ->with(
                'lawyerDetails.SectionsRel'
            )
            ->get();
        $visitors = Visitor::get();
        $lawyer_sections = DigitalGuideCategories::get();
        $clientsFcm = AccountFcm::whereIn('account_id', $clients->map(function ($model) {
            return $model->id;
        }))->pluck('account_id');
        $lawyersFcm = AccountFcm::whereIn('account_id', $lawyers->map(function ($model) {
            return $model->id;
        }))->pluck('account_id');
        $visitorsFcm = VisitorFCM::whereIn('visitor_id', $visitors->map(function ($model) {
            return $model->id;
        }))->pluck('visitor_id');

        $clients = $clients->filter(function ($model) use ($clientsFcm) {
            return $clientsFcm->contains($model->id);
        })->values();
        $lawyers = $lawyers->filter(function ($model) use ($lawyersFcm) {
            return $lawyersFcm->contains($model->id);
        })->values();
        $visitors = $visitors->filter(function ($model) use ($visitorsFcm) {
            return $visitorsFcm->contains($model->id);
        })->values();
        return Inertia::render('Notifications/index', get_defined_vars());
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            "type" => "required|in:0,1,2,3,4,5,6,7",
            "notification_type" => "required|in:1,2,3,4",
            "user_ids" => "required_if:type,4,5,6|array",
            "subject" => "required",
            "description" => "required"
        ], [
            "type.required" => "يجب تحديد نوع الطلب",
            "type.in" => "القيمة المدخلة لنوع الطلب غير صالحة",
            "notification_type.required" => "يجب تحديد نوع الإشعار",
            "notification_type.in" => "القيمة المدخلة لنوع الإشعار غير صالحة",
            "user_ids.required_if" => "حقل قائمة المستخدمين مطلوب عندما يكون نوع الطلب 4, 5, 6",
            "user_ids.array" => "حقل قائمة المستخدمين يجب أن يكون مصفوفة",
            "subject.required" => "حقل الموضوع مطلوب",
            "description.required" => "حقل الوصف مطلوب"
        ]);
        $notificationType = "global";
        switch ($request->notification_type) {
            case 1:
                $notificationType = "global";
                break;
            case 2:
                $notificationType = "laws";
                break;
            case 3:
                $notificationType = "store-update";
                break;
            case 4:
                $notificationType = "inapp-update";
                break;
        }
        if ($request->type == "0") {
            $users = AccountFcm::pluck('fcm_token')->toArray();
            $notificationUsersIds = AccountFcm::distinct()->pluck('account_id')->toArray();
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }
        } else if ($request->type == "1") {
            $users = AccountFcm::whereHas('account', function ($query) {
                $query->where('account_type', 'client');
            })->pluck('fcm_token')->toArray();
            $notificationUsersIds = AccountFcm::whereHas('account', function ($query) {
                $query->where('account_type', 'client');
            })->distinct()->pluck('account_id')->toArray();
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }
        } else if ($request->type == "2") {
            $users = AccountFcm::whereHas('account', function ($query) {
                $query->where('account_type', 'lawyer');
            })->pluck('fcm_token')->toArray();
            $notificationUsersIds = AccountFcm::whereHas('account', function ($query) {
                $query->where('account_type', 'lawyer');
            })->distinct()->pluck('account_id')->toArray();
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }

        } else if ($request->type == "3") {
            $users = VisitorFCM::pluck('fcm_token')->toArray();
            $notificationUsersIds = VisitorFCM::distinct()->pluck('visitor_id')->toArray();
            // foreach ($notificationUsersIds as $notificationUserId) {
            //     $notification = new Notification();
            //     $notification->description = $request->description;
            //     $notification->seen = false;
            //     $notification->type = $notificationType;
            //     $notification->lawyer_id = $notificationUserId;
            //     $notification->userType = "visitor";
            //     $notification->title = $request->subject;
            //     $notification->save();
            // }
        } else if ($request->type == "4") {
            $users = AccountFcm::whereIn('account_id', $request->user_ids)->pluck('fcm_token')->toArray();
            $notificationUsersIds = $request->user_ids;
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }
        } else if ($request->type == '5') {
            $users = AccountFCM::whereIn('account_id', $request->user_ids)->pluck('fcm_token')->toArray();
            $notificationUsersIds = $request->user_ids;
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }

        } else if ($request->type == "6") {
            $users = VisitorFCM::whereIn('client_id', $request->user_ids)->pluck('fcm_token')->toArray();
            $notificationUsersIds = $request->user_ids;
            foreach ($notificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }
        } else if ($request->type == '7') {
            $accounts = AccountFCM::pluck('fcm_token')->toArray();
            $visitors = VisitorFCM::pluck('fcm_token')->toArray();
            $clientNotificationUsersIds = AccountFCM::distinct()->pluck('account_id')->toArray();
            foreach ($clientNotificationUsersIds as $notificationUserId) {
                $notification = new Notification();
                $notification->description = $request->description;
                $notification->seen = false;
                $notification->type = $notificationType;
                $notification->account_id = $notificationUserId;
                $notification->title = $request->subject;
                $notification->save();
            }
            // $visitorNotificationUsersIds = VisitorFCM::distinct()->pluck('client_id')->toArray();
            // foreach ($visitorNotificationUsersIds as $notificationUserId) {
            //     $notification = new Notification();
            //     $notification->description = $request->description;
            //     $notification->seen = false;
            //     $notification->type = $notificationType;
            //     $notification->account_id = $notificationUserId;
            //     $notification->title = $request->subject;
            //     $notification->save();
            // }
            $users = collect($accounts)->merge($visitors)->toArray();
        }
        if (count($users) == 0) {
            return response()->json([
                "status" => "false",
                "message" => "الحسابات المختارة ليست لها خاصية الأشعارات بعد"
            ])->setStatusCode(400);
        }
        $pushNotificationController = new PushNotificationController;
        $pushNotificationController->sendNotification($users, $request->subject, $request->description, []);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
