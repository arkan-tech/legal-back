<?php

namespace App\Http\Controllers\Site\Client\ServicesRequests;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientLawyersMessage;
use App\Models\Client\ClientRequest;
use App\Models\Client\ClientRequestRates;
use App\Models\Client\ClientRequestReplies;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Service\ServiceUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServicesRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $client = auth()->guard('client')->user();
        $client_requests = ClientRequest::with('priorityRel')->where('transaction_complete', 1)->where('client_id', $client->id)->with('type')->orderBy('created_at', 'desc')->get();
        return view('site.client.services_requests.index', compact('client_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id = null)
    {
        $client = auth()->guard('client')->user();
        $services = Service::where('status', 1)->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        return view('site.client.services_requests.create', get_defined_vars());

    }

    public function createWithLawyer($id, $lawyer_id)
    {
        $client = auth()->guard('client')->user();
        $services = Service::where('status', 1)->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        return view('site.client.services_requests.create_with_lawyer', get_defined_vars());

    }

    public function CreateClientService($service_id)
    {
        $services = Service::where('status', 1)->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        return view('site.client.services_requests.create_client_service', get_defined_vars());

    }

    public function StoreClientService(Request $request)
    {

        $request->validate([
            '*' => 'required',
            'client_email' => 'required|email|unique:service_users,email',
            'service_file' => 'sometimes',
            'client_idnumber' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب',
            'client_email.required' => 'الحقل مطلوب',
            'client_email.email' => 'الرجاء ادخال ايميل صحيح ',
            'client_email.unique' => 'الايميل موجود مسبقاً ',
        ]);

        $client_password = rand(1000000, 1000000000);
        $client = ServiceUser::create([
            'username' => $request->client_email,
            'email' => $request->client_email,
            'password' => bcrypt($client_password),
            'myname' => $request->client_name,
            'mobil' => $request->client_mobile,
            'idnum' => $request->client_idnumber,
            'type' => $request->client_type,
        ]);
        $service_request = ClientRequest::create([
            'client_id' => $client->id,
            'type_id' => $request->service_type,
            'priority' => $request->service_priority,
            'description' => $request->service_description,
            'referral_status' => 1,
            'for_admin' => 1,
        ]);
        $file = null;
        if ($request->has('service_file')) {
            $file = saveImage($request->file('service_file'), 'uploads/client/service_request');
            $service_request->file = $file;
            $service_request->update();
        }
        $replay = ClientRequestReplies::create([
            'client_requests_id' => $service_request->id,
            'replay' => $request->description,
            'from_admin' => 1,
            'replay_laywer_id' => null,
            'from' => 1
            ,
        ]);
        if ($request->has('file')) {
            $replay->file = $file;
            $replay->update();
        }
        $bodyMessage = 'مرحباً بك عميلنا العزيز , اليك بيانات الدخول إلى حسابك لمتابعة طلباتك ,';
        $bodyMessage1 = 'الايميل : ' . ' ' . $client->email;
        $bodyMessage2 = 'كلمة المرور : ' . ' ' . $client_password;
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
        return \response()->json([
            'status' => true,
            'msg' => 'تهانينا لك عميلنا العزيز , لقد تم استلام طلبك بنجاح , وتم ارسال لك بيانات الدخول على الايميل حتى تتمكن من متابعة طلبك والاستمتاع بالخدمات التي يسعدنا تقديمها لك , شكراً .',
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'file' => 'sometimes'
        ], [
            '*.required' => 'الرجاء ادخال الحقل'
        ]);
        $service = Service::where('id', $request->type)->first();
        $client = auth()->guard('client')->user();
        $service_request = ClientRequest::create([
            'client_id' => $request->client_id,
            'type_id' => $request->type,
            'priority' => $request->priority,
            'description' => $request->description,
            'status' => 1,
            'for_admin' => 1,
            'referral_status' => 1,
            'replay_status' => 0,
            'request_status' => 0,
            'accept_rules' => 1,
            'transaction_complete' => 0,
            'price' => $service->ymtaz_price == 0 ? $service->min_price : $service->ymtaz_price,
        ]);
        $file = null;
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request');
            $service_request->file = $file;
            $service_request->update();
        }
        $replay = ClientRequestReplies::create([
            'client_requests_id' => $service_request->id,
            'replay' => $request->description,
            'from_admin' => 1,
            'replay_laywer_id' => null,
            'from' => 1
            ,
        ]);
        if ($request->has('file')) {
            $replay->file = $file;
            $replay->update();
        }

        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $service->ymtaz_price == 0 ? $service->min_price : $service->ymtaz_price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $client->email,
            'bill_fname' => $client->myname,
            'bill_sname' => $client->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => route('site.client.service-request.CompletePaymentClientServicesRequests', $service_request->id),
            'return_can' => route('site.client.service-request.CancelPaymentClientServicesRequests', $service_request->id),
            'return_decl' => route('site.client.service-request.DeclinedPaymentClientServicesRequests', $service_request->id),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);

        if ($results === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        $results = json_decode($results, true);

        $service_request->update([
            'transaction_id' => $results['order']['ref'],
        ]);
        $transaction_id = $results['order']['ref'];
        $payment_url = $results['order']['url'];


        return \response()->json([
            'status' => true,
            'msg' => 'تم استلام طلبك بنجاح , انتظر الرد عليك في اقرب وقت , شكراً لحسن تعوانكم معنا .',
            'payment_url' => $payment_url
        ]);
    }

    public function storeWithLawyer(Request $request)
    {
        $request->validate([
            '*' => 'required',
            'file' => 'sometimes'
        ], [
            '*.required' => 'الرجاء ادخال الحقل'
        ]);
        $service = Service::where('id', $request->type)->first();
        $client = auth()->guard('client')->user();
        $service_request = ClientRequest::create([
            'client_id' => $request->client_id,
            'lawyer_id' => $request->lawyer_id,
            'type_id' => $request->type,
            'priority' => $request->priority,
            'description' => $request->description,
            'status' => 1,
            'for_admin' => 2,
            'replay_status' => 0,
            'request_status' => 0,
            'referral_status' => 2,
            'accept_rules' => 1,
            'transaction_complete' => 0,
            'price' => $service->ymtaz_price == 0 ? $service->min_price : $service->ymtaz_price,
        ]);
        $file = null;
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request');
            $service_request->file = $file;
            $service_request->update();
        }
        $replay = ClientRequestReplies::create([
            'client_requests_id' => $service_request->id,
            'replay' => $request->description,
            'from_admin' => 1,
            'replay_laywer_id' => null,
            'from' => 1
            ,
        ]);
        if ($request->has('file')) {
            $replay->file = $file;
            $replay->update();
        }

        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $service->ymtaz_price == 0 ? $service->min_price : $service->ymtaz_price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $client->email,
            'bill_fname' => $client->myname,
            'bill_sname' => $client->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => route('site.client.service-request.CompletePaymentClientServicesRequests', $service_request->id),
            'return_can' => route('site.client.service-request.CancelPaymentClientServicesRequests', $service_request->id),
            'return_decl' => route('site.client.service-request.DeclinedPaymentClientServicesRequests', $service_request->id),
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        $results = curl_exec($ch);

        if ($results === false) {
            throw new Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);

        $results = json_decode($results, true);

        $service_request->update([
            'transaction_id' => $results['order']['ref'],
        ]);
        $transaction_id = $results['order']['ref'];
        $payment_url = $results['order']['url'];


        return \response()->json([
            'status' => true,
            'msg' => 'تم استلام طلبك بنجاح , انتظر الرد عليك في اقرب وقت , شكراً لحسن تعوانكم معنا .',
            'payment_url' => $payment_url
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    public function ShowRequestReplies($id)
    {
        $client = auth()->guard('client')->user();
        $requests = ClientRequest::where('client_id', $client->id)->pluck('id')->toArray();
        if (!in_array($id, $requests)) {
            return abort(404);
        } else {
            $request = ClientRequest::findOrFail($id);
            $replies = ClientRequestReplies::where('client_requests_id', $id)->get();
            return view('site.client.services_requests.replies', get_defined_vars());
        }
    }

    public function SendClientRequestReplay(Request $request)
    {

        $reply = ClientRequestReplies::create([
            'client_requests_id' => $request->client_requests_id,
            'from_admin' => $request->from_admin,
            'replay' => $request->replay,
            'from' => $request->from,
        ]);
        if ($request->has('file')) {
            $reply->file = saveImage($request->file('file'), 'uploads/client/service_request');
            $reply->update();
        }


        $chats = view('site.client.services_requests.chat_in', compact('reply'))->render();
        return \response()->json([
            'status' => true,
            'chats' => $chats
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
    public function update(Request $request, $id)
    {
        //
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

    public function SendClientRateRequestReplay(Request $request)
    {
        $request->validate([
            'rate' => 'required',
        ], [
            'rate.required' => 'يجب اختيار تقييم'
        ]);
        $ClientRequest = ClientRequest::findOrFail($request->request_id);
        ClientRequestRates::create(
            [
                'client_service_request_id' => $request->request_id,
                'client_id' => $ClientRequest->client_id,
                'rate' => $request->rate,
                'comment' => $request->comment
            ]
        );

        return \response()->json([
            'status' => true
        ]);

    }

    public function CompletePaymentClientServicesRequests(Request $request, $id)
    {
        $ClientRequest = ClientRequest::findOrFail($id);
        $ClientRequest->update([
            'transaction_complete' => 1
        ]);
        if (auth()->guard('client')->check()) {
            return redirect()->route('site.client.service-request.index');

        } else {
            return redirect()->route('site.index');
        }
    }

    public function CancelPaymentClientServicesRequests(Request $request, $id)
    {
        $ClientRequest = ClientRequest::findOrFail($id);
        $ClientRequest->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientServicesRequests(Request $request, $id)
    {
        $ClientRequest = ClientRequest::findOrFail($id);
        $ClientRequest->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPayment');
    }

}
