<?php

namespace App\Http\Controllers\NewAdmin;

use App\Models\Account;
use App\Models\MailerAccounts;
use Inertia\Inertia;
use App\Models\LawyerOld;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use App\Models\Regions\Regions;
use App\Models\Service\ServiceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\DigitalGuide\DigitalGuideCategories;


class MailerController extends Controller
{
    public function index()
    {
        $clients = Account::whereNotNull("email")->where('account_type', 'client')->select('id', 'name', 'email', 'region_id')->get();
        $lawyers = Account::whereNotNull("email")->where('account_type', 'lawyer')->with(
            'lawyerDetails.SectionsRel'
        )->get();
        $mailer = MailerAccounts::where('is_subscribed', 1)->get();
        $lawyer_sections = DigitalGuideCategories::get();
        $regions = Regions::get();
        $old_clients = ServiceUserOld::whereNotNull("email")->select('id', 'myname', 'email', 'region_id')->where('accepted', 0)->get();
        $old_lawyers = LawyerOld::whereNotNull("email")->select('id', 'name', 'email', 'region')->with([
            'SectionsRel' => function ($query) {
                $query->select('section_id');
            }
        ])->where('accepted', 0)->get();
        return Inertia::render('Mailer/index', get_defined_vars());
    }
    public function sendMail(Request $request)
    {
        $request->validate([
            "type" => "required|in:1,2,3,4,5,6,7,8,9,10",
            "user_ids" => "required_if:type,3,4|array",
            "subject" => "required",
            "description" => "required_if:mailType,email",
            "mailType" => "required"
        ], [
            "type.required" => "يجب تحديد نوع الطلب",
            "type.in" => "القيمة المدخلة لنوع الطلب غير صالحة",
            "user_ids.required_if" => "حقل قائمة المستخدمين مطلوب عندما يكون نوع الطلب 1، 2، 3، 4، أو 5",
            "user_ids.array" => "حقل قائمة المستخدمين يجب أن يكون مصفوفة",
            "subject.required" => "حقل الموضوع مطلوب",
            "description.required" => "حقل الوصف مطلوب",
            "mailType.required" => "حقل نوع البريد الإلكتروني مطلوب"
        ]);

        if ($request->type == "1") {
            $users = Account::whereNotNull("email")->where('account_type', 'client')->distinct()->pluck("email")->toArray();
        } else if ($request->type == "2") {
            $users = Account::whereNotNull("email")->where('account_type', 'lawyer')->distinct()->pluck("email")->toArray();
        } else if ($request->type == "3") {
            $users = Account::whereNotNull("email")->where('account_type', 'client')->whereIn('id', $request->user_ids)->distinct()->pluck('email')->toArray();
        } else if ($request->type == '4') {
            $users = Account::whereNotNull("email")->where('account_type', 'lawyer')->where('id', $request->user_ids)->distinct()->pluck('email')->toArray();
        } else if ($request->type == '5') {
            $lawyers = Account::whereNotNull("email")->where('account_type', 'lawyer')->distinct()->pluck('email')->toArray();
            $clients = Account::whereNotNull("email")->where('account_type', 'client')->distinct()->pluck('email')->toArray();
            $users = collect($lawyers)->merge($clients)->toArray();
        } else if ($request->type == "6") {
            $users = ServiceUserOld::whereNotNull("email")->distinct()->pluck("email")->toArray();
        } else if ($request->type == "7") {
            $users = LawyerOld::whereNotNull("email")->distinct()->pluck("email")->toArray();
        } else if ($request->type == "8") {
            $users = ServiceUserOld::whereNotNull("email")->whereIn('id', $request->user_ids)->distinct()->pluck('email')->toArray();
        } else if ($request->type == "9") {
            $users = ServiceUserOld::whereNotNull("email")->whereIn('id', $request->user_ids)->distinct()->pluck('email')->toArray();
        } else if ($request->type == '10') {
            $users = MailerAccounts::where('is_subscribed', 1)->whereIn('id', $request->user_ids)->distinct()->pluck('email')->toArray();
        }
        $emailData = [
            'subject' => $request->subject,
            'bodyMessage' => nl2br(e($request->description ?? "")),
            'bodyMessage1' => "",
            "bodyMessage2" => "",
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        Mail::send(
            $request->mailType,
            $emailData,
            function ($message) use ($emailData, $users) {
                $message->from('ymtaz@ymtaz.sa');
                $message->bcc($users)->subject($emailData['subject']);
            }
        );
        return response()->json([
            'status' => 'success',
        ]);
    }
}
