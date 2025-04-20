<?php

namespace App\Http\Controllers\Site\Lawyer\ClientServiceRequests;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientRequest;
use App\Models\Client\ClientRequestReplies;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class ClientServiceRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawyer = auth()->guard('lawyer')->user();
        $requests = ClientRequest::where('lawyer_id', $lawyer->id)->where('transaction_complete', 1)->with('client', 'type')->orderBy('created_at', 'desc')->get();
        return view('site.lawyers.clients-service-requests.index', get_defined_vars());
    }

    public function ShowRequestContacts($id)
    {
        $replies = ClientRequestReplies::where('client_requests_id', $id)->get();
        $request = ClientRequest::where('id', $id)->with('client')->first();
        $lawyer = auth()->guard('lawyer')->user();
        return view('site.lawyers.clients-service-requests.chat', get_defined_vars());
    }

    public function SendRequestMessage(Request $request)
    {
        $reply = ClientRequestReplies::create([
            'client_requests_id' => $request->client_requests_id,
            'from_admin' => $request->from_admin,
            'from' => $request->from,
            'replay_laywer_id' => $request->replay_laywer_id,
            'replay' => $request->replay,
            //            'replay_status' => 1,
        ]);
        if ($request->has('file')) {
            $reply->file = saveImage($request->file('file'), 'uploads/client/service_request');
            $reply->update();
        }

        $chats = view('site.lawyers.clients-service-requests.chat_out', compact('reply'))->render();
        return \response()->json([
            'status' => true,
            'chats' => $chats
        ]);
    }

    public function SendFinalReplay(Request $request)
    {
        $item = ClientRequest::with('client')->findOrFail($request->id);
        $item->update([
            'replay' => $request->message,
            'replay_from_lawyer_id' => $request->replay_from_lawyer_id,
            'replay_from_admin' => 2,
            'replay_status' => 1,
            'request_status' => 2,
            'referral_status' => 3,
            'replay_time' => date("h:i:s"),
            'replay_date' => date("Y-m-d"),
        ]);
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request/replay_file/');
            $item->update(['replay_file' => $file]);
        }
        $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
        $bodyMessage2 = $request->message;
        $bodyMessage3 = !is_null($item->replay_file) ? 'الملف : ' . ' ' . $item->replay_file : '';
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
            'name' => $item->client->myname,
            'email' => ($item->client->email),
            'subject' => "رد على طلب خدمة .",
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
        return \response()->json([
            'status' => true
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = ClientRequest::with('client', 'type')->findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function changeReferralStatus(Request $request)
    {
        $client_request = ClientRequest::findOrFail($request->request_id);
        $client_request->update([
            'referral_status' => $request->referral_status
        ]);
        return \response()->json([
            'status' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
