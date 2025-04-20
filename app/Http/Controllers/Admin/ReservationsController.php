<?php

namespace App\Http\Controllers\Admin;

use App\Models\Account;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyersAdvisorys;
use App\Models\Reservations\Reservation;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationReply;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class ReservationsController extends Controller
{

    public function indexClient()
    {
        $requests = Reservation::with(['account', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Reservations-Requests/client/index', get_defined_vars());

    }
    public function indexLawyer()
    {
        $requests = Reservation::with(['lawyer', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Reservations-Requests/lawyer/index', get_defined_vars());

    }
    public function indexForLawyerFromClient()
    {
        $requests = Reservation::with(['account', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Reservations-Requests/forLawyer/client/index', get_defined_vars());

    }
    public function indexForLawyerFromLawyer()
    {
        $requests = Reservation::with(['lawyer', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Reservations-Requests/forLawyer/lawyer/index', get_defined_vars());

    }

    public function editClient($id)
    {
        $item = Reservation::with(['account', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->orderBy('created_at', 'desc')->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Account::where('account_type', 'lawyer')->where('status', 2)->with('lawyerDetails.lawyerAdvisories')->get();
        return Inertia::render('Reservations-Requests/client/Edit/index', get_defined_vars());
    }
    public function editClientForLawyer($id)
    {
        $item = Reservation::with(['account', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->orderBy('created_at', 'desc')->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Account::where('account_type', 'lawyer')->where('status', 2)->with('lawyerDetails.lawyerAdvisories')->get();
        return Inertia::render('Reservations-Requests/forLawyer/client/Edit/index', get_defined_vars());
    }
    public function editLawyer($id)
    {
        $item = Reservation::with(['lawyer', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->orderBy('created_at', 'desc')->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Account::where('account_type', 'lawyer')->where('status', 2)->with('lawyerDetails.lawyerAdvisories')->get();
        return Inertia::render('Reservations-Requests/lawyer/Edit/index', get_defined_vars());
    }
    public function editLawyerForLawyer($id)
    {
        $item = Reservation::with(['lawyer', 'lawyer.lawyerDetails.lawyerAdvisories', 'reservationType', 'importance'])->orderBy('created_at', 'desc')->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Account::where('account_type', 'lawyer')->where('status', 2)->with('lawyerDetails.lawyerAdvisories')->get();
        return Inertia::render('Reservations-Requests/forLawyer/lawyer/Edit/index', get_defined_vars());
    }

    public function SendFinalReplay(Request $request)
    {
        $item = Reservation::findOrFail($request->id);
        $item->update([
            'request_status' => 1,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'reserved_from_lawyer_id' => $request->lawyer_id,
            'transferTime' => Carbon::now()->toDateTimeString()
        ]);

        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/advisory_services/replay_file/reservations/');
            $item->update(['replay_file' => $file]);
        }
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $lawyer_bodyMessage1 = ' تم تحويل لك موعد عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (مواعيد مُحالة لك ):';
        $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
        $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على المواعيد المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
        $bodyMessage4 = 'لتسجيل الدخول ';
        $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage6 = 'لاستعادة كلمة المرور :';
        // $bodyMessage7 = env('REACT_WEB_LINK') . !is_null($item->lawyer_id) ? "/auth/forgetPassword?userType=lawyer" : "/auth/forgetPassword?userType=client";
        $bodyMessage6 = "";
        $bodyMessage7 = "";
        $bodyMessage8 = 'للتواصل والدعم الفني :';
        $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage10 = 'نعتز بثقتكم';
        $lawyer_data = [
            'name' => $lawyer->name,
            'email' => $lawyer->email,
            'subject' => "تحويل موعد جديد من يمتاز . ",
            'bodyMessage' => $lawyer_bodyMessage,
            'bodyMessage1' => $lawyer_bodyMessage1,
            'bodyMessage2' => $lawyer_bodyMessage2,
            'bodyMessage3' => $lawyer_bodyMessage3,
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
            $lawyer_data,
            function ($message) use ($lawyer_data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($lawyer_data['email'], $lawyer_data['name'])->subject($lawyer_data['subject']);
            }
        );

        return \response()->json([
            'status' => true
        ]);
    }

}
