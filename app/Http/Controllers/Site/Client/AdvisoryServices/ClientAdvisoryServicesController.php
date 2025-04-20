<?php

namespace App\Http\Controllers\Site\Client\AdvisoryServices;

use App\Http\Controllers\Controller;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\ClientAdvisoryServicesAppointment;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\Lawyer\Lawyer;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Lawyer\LawyerWorkDays;
use App\Models\Lawyer\LawyerWorkDayTimes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class ClientAdvisoryServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reservations = ClientAdvisoryServicesReservations::where('client_id',auth()->guard('client')->user()->id)
            ->with('service','type','importanceRel','lawyer','appointment')
            ->where('transaction_complete',1)
            ->orderBy('created_at','desc')
            ->get();
        return  view('site.client.AdvisoryServices.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($lawyer_id)
    {
        $AdvisoryServicesTypes = AdvisoryServicesTypes::get();
        $AdvisoryServices = AdvisoryServices::where('status',1)->get();
        $services = LawyersServicesPrice::with('service')->where('lawyer_id',$lawyer_id)->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        $lawyer_dates  = LawyerWorkDays::with('times')->where('lawyer_id',$lawyer_id)->get();
        return  view('site.client.AdvisoryServices.create',get_defined_vars());
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
            'advisory_services_id'=>'required',
            'type'=>'required',
            'priority'=>'required',
            'description'=>'required',
            'time_id'=>'required',
        ],[
            'advisory_services_id.required'=>'الحقل مطلوب ',
            'type.required'=>'الحقل مطلوب ',
            'priority.required'=>'الحقل مطلوب ',
            'description.required'=>'الحقل مطلوب ',
            'time_id.required'=>' يجب تحديد موعد ',
        ]);
        $client = auth()->guard('client')->user();
        $advisory = AdvisoryServices::where('id', $request->advisory_services_id)->first();
        $reservation = ClientAdvisoryServicesReservations::create([
            'client_id' => $request->client_id,
            'advisory_services_id' => $advisory->id,
            'type_id' => $request->type,
            'importance_id' => $request->priority,
            'description' => $request->description,
            'accept_rules' => 1,
            'lawyer_id' => $request->lawyer_id,
            'payment_status' => 0,
            'transaction_complete' => 0,
            'reservation_status' => 2,
            'price' => $advisory->price,
            'accept_date' => date("Y-m-d"),
        ]);
        if (array_key_exists('file', $request->all()) == true) {
            $reservation->update([
                'file' => saveImage($request->file, 'uploads/advisory_services/reservations/')
            ]);
        }
        $time = LawyerWorkDayTimes::where('id',$request->time_id)->first();
        $date = LawyerWorkDays::where('id',$time->day_id)->first();
        $appointment = ClientAdvisoryServicesAppointment::create([
            'client_id' => $request->client_id,
            'client_advisory_services_reservation_id' => $reservation->id,
            'advisory_services_id' =>$advisory->id,
            'advisory_services_date_id' => $date->id,
            'advisory_services_time_id' => $time->id,
            'date'=>$date->day_name,
            'time_from'=>$time->time_from,
            'time_to'=>$time->time_to,
        ]);

        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $advisory->price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $client->email,
            'bill_fname' => $client->myname,
            'bill_sname' => $client->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => route('site.client.advisory-services.CompletePaymentClientAdvisoryServices', $reservation->id),
            'return_can' => route('site.client.advisory-services.CancelPaymentClientAdvisoryServices', $reservation->id),
            'return_decl' => route('site.client.advisory-services.DeclinedPaymentClientAdvisoryServices', $reservation->id),

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
        $reservation->update([
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




    public function CompletePaymentClientAdvisoryServices(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 1
        ]);
        if (auth()->guard('client')->check()) {
            return redirect()->route('site.client.advisory-services.index');

        } else {
            return redirect()->route('site.index');
        }
    }

    public function CancelPaymentClientAdvisoryServices(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 2
        ]);
        return view('site.api.cancelPayment');
    }

    public function DeclinedPaymentClientAdvisoryServices(Request $request, $id)
    {
        $ClientAdvisoryServicesReservations = ClientAdvisoryServicesReservations::findOrFail($id);
        $ClientAdvisoryServicesReservations->update([
            'transaction_complete' => 3
        ]);
        return view('site.api.declinedPayment');
    }

}