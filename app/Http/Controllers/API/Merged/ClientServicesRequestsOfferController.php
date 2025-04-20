<?php
namespace App\Http\Controllers\API\Merged;

use App\Http\Controllers\API\payments\PaymentController;
use Illuminate\Http\Request;
use App\Models\LawyerPayments;
use App\Models\ServiceRequestOffer;
use App\Models\ServicesReservations;
use App\Http\Resources\AccountResource;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\ServiceRequestOfferResource;
use App\Http\Resources\API\Services\ServicesResource;
use App\Http\Resources\AdvisoryServicesReservationFileResource;
use App\Http\Tasks\Client\Services\ClientCreateServicesRequestsTask;
use App\Http\Requests\API\Client\Services\ClientCreateServicesRequestsRequest;
use App\Http\Resources\API\Client\Reservations\Requirements\ClientReservationsImportanceResource;
use App\Models\Notification;
use App\Models\AccountFcm;
use App\Http\Controllers\PushNotificationController;
use Illuminate\Support\Facades\Crypt;

class ClientServicesRequestsOfferController extends BaseController
{
    public function getOffers()
    {
        $client = $this->authAccount();

        $offers = ServiceRequestOffer::where('account_id', $client->id)
            ->with('lawyer', 'files', 'service', 'account', 'importance')
            ->get()
            ->groupBy('status');

        $groupedOffers = [
            'accepted' => [],
            'pending-acceptance' => [],
            'pending-offer' => [],
            'cancelled-by-client' => [],
        ];
        foreach ($offers as $status => $offerGroup) {
            $groupedOffers[$status] = ServiceRequestOfferResource::collection($offerGroup);
        }

        return $this->sendResponse(true, 'Offers fetched successfully.', ['offers' => $groupedOffers], 200);
    }


    public function respondToOffers(Request $request)
    {
        $client = $this->authAccount();

        // dd($client);
        // $offer = ServiceRequestOffer::where('id', $request->offer_id)
        // ->where('account_id', $client->id)
        // ->where('status', 'pending-acceptance')
        // ->first();
        $offer = ServiceRequestOffer::find($request->offer_id);

        if (!$offer) {
            return response()->json(['message' => 'العرض غير موجود.'], 404);
        }
        
        if ($offer->account_id != $client->id) {
            return response()->json(['message' => 'هذا العرض لا يخص هذا العميل.'], 403);
        }
        
        if ($offer->status != 'pending-acceptance') {
            return response()->json(['message' => 'العرض ليس في حالة انتظار القبول.'], 400);
        }
        
        // dd('here',$offer );
        if ($request->action == 'accept') {
            $offer->status = 'accepted';
            $offer->save();

            // Create a reservation using ServicesReservations model
            $service_request = ServicesReservations::create([
                'account_id' => $client->id,
                'type_id' => $offer->service_id,
                'priority' => $offer->importance_id,
                'description' => $offer->service->description ?? '',
                'for_admin' => 2,
                'reserved_from_lawyer_id' => $offer->lawyer_id,
                'payment_status' => 0,
                'price' => $offer->price,
                'accept_rules' => 1,
                'transaction_complete' => 0,
                'status' => 1,
                'request_status' => 1,
            ]);
            $offer->files()->each(function ($file) use ($service_request) {
                $file->update(['reservation_id' => $service_request->id]);
            });
            // Handle payment
            $Domain = route('site.index');
            $splittedName = explode(' ', $client->name);
            $firstName = $splittedName[0];
            $lastName = $splittedName[count($splittedName) - 1];
            $orderNumber = "ORD-SERV-" . $service_request->id;
            // $params = array(
            //     'action' => 'SALE',
            //     'edfa_merchant_id' => "05084137-f149-4fa3-bc14-492d13e3b6dd",
            //     "order_id" => $orderNumber,
            //     "order_amount" => $service_request->price,
            //     "order_currency" => "SAR",
            //     "order_description" => "Order for a customer",
            //     "req_token" => "N",
            //     "payer_first_name" => $firstName,
            //     "payer_last_name" => $lastName,
            //     'payer_address' => $client->email,
            //     "payer_country" => "SA",
            //     "payer_zip" => "12221",
            //     "payer_email" => $client->email,
            //     "payer_phone" => $client->phone,
            //     "payer_ip" => "127.0.0.1",
            //     "term_url_3ds" => $Domain . '/api/payments/callback/account/services/' . $service_request->id,
            //     "auth" => "N",
            //     "recurring_init" => "N",
            //     "hash" => sha1(md5(strtoupper($orderNumber . $service_request->price . "SAR" . "Order for a customer" . "d6c2ea8fb0df4efa00be1014dba3c806")))
            // );

            // // Initiate payment request
            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "https://api.edfapay.com/payment/initiate");
            // curl_setopt($ch, CURLOPT_POST, count($params));
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, ['Expect:']);
            // $results = curl_exec($ch);


            $data = [
                'amount' => $service_request->price,
                'description' => 'Order for a customer',
                'userId' => $client->id,
                'serviceCate'=>'service',
                'serviceId' => $service_request->id,
                'requester_type' => 'client',
                'orderNumber'=> $orderNumber,
                
            ];
            $encryptedData = Crypt::encrypt(json_encode($data));
            $transaction_id = $orderNumber;
            $payment_url = route('payment.showForm', ['data' => $encryptedData]);
            // Redirect to the payment form with POST data
            // return redirect()->route('payment.showForm')
            //     ->withInput($data);

                
            // if ($results === false) {
            //     throw new \Exception(curl_error($ch), curl_errno($ch));
            // }
            // curl_close($ch);

            // $results = json_decode($results, true);
            // Update service request with transaction details
            // $service_request->update([
            //     'transaction_id' => $transaction_id,
            // ]);

            // Create LawyerPayments record
            LawyerPayments::create([
                'account_id' => $offer->lawyer_id,
                'product_id' => $service_request->id,
                'product_type' => 'service',
                'requester_type' => 'client',
            ]);

            // Notify lawyer about the accepted offer
            $notification = Notification::create([
                'title' => "قبول العرض",
                "description" => "تم قبول عرضك من قبل العميل.",
                "type" => "service-offer-lawyer",
                "type_id" => $offer->id,
                "account_id" => $offer->lawyer_id,
            ]);
            $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
            if (count($fcms) > 0) {
                $notificationController = new PushNotificationController;
                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
            }


            // Return response
            return $this->sendResponse(true, 'Offer accepted. Please proceed to payment.', [
                'service_request' => $service_request,
                'transaction_id' => $transaction_id,
                'payment_url' => $payment_url,
            ], 200);
        } elseif ($request->action == 'decline') {
            $offer->status = 'declined';
            $offer->save();

            // Notify lawyer about the declined offer
            $notification = Notification::create([
                'title' => "رفض العرض",
                "description" => "تم رفض عرضك من قبل العميل.",
                "type" => "service-offer-lawyer",
                "type_id" => $offer->id,
                "account_id" => $offer->lawyer_id,
            ]);
            $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
            if (count($fcms) > 0) {
                $notificationController = new PushNotificationController;
                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
            }

            return $this->sendResponse(true, 'Offer declined.', null, 200);
        } else {
            return $this->sendResponse(false, 'Invalid action.', null, 400);
        }
    }

    public function create(ClientCreateServicesRequestsRequest $request)
    {
        $client = $this->authAccount();
        $serviceId = $request->service_id;
        $priority = $request->priority;
        $description = $request->description;
        $acceptRules = $request->accept_rules;
        $lawyerIds = $request->lawyer_ids;
        $serviceRequests = [];

        foreach ($lawyerIds as $lawyerId) {
            // Create a service request for each lawyer
            $serviceRequest = ServicesReservations::create([
                'account_id' => $client->id,
                'type_id' => $serviceId,
                'priority' => $priority,
                'description' => $description,
                'for_admin' => 2,
                'reserved_from_lawyer_id' => $lawyerId,
                'referral_status' => 1,
                'payment_status' => 0, // Pending payment
                'price' => 0, // Price to be set when offer is accepted
                'accept_rules' => $acceptRules,
                'transaction_complete' => 0,
                'status' => 'pending',
                // ...other fields as necessary...
            ]);

            if ($request->has('files')) {
                foreach ($request->file('files') as $file) {
                    $filePath = saveImage($file, 'uploads/services-requests/');
                    $serviceRequest->files()->create(['file' => $filePath, 'is_reply' => 1]);
                }
            }

            // Save voice file if present
            if ($request->hasFile('voice_file')) {
                $voiceFilePath = saveImage($request->file('voice_file'), 'uploads/services-requests/');
                $serviceRequest->files()->create(['file' => $voiceFilePath, 'is_reply' => 1, 'is_voice' => 1]);
            }

            $serviceRequests[] = $serviceRequest;


        }

        return $this->sendResponse(true, 'Service requests created successfully.', ['service_requests' => $serviceRequests], 201);
    }

    public function createViaTask(ClientCreateServicesRequestsRequest $request)
    {
        $task = new ClientCreateServicesRequestsTask();
        $response = $task->run($request);

        if ($response['status']) {
            return $this->sendResponse(true, $response['message'], $response['data'], 201);
        } else {
            return $this->sendResponse(false, $response['message'], null, $response['code']);
        }
    }
}