<?php

namespace App\Http\Controllers\API\Merged\Reservations;

use App\Http\Tasks\Merged\Reservations\LawyerGetReservationRequestsTask;
use App\Models\AccountFcm;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LawyerPayments;
use App\Models\Reservations\Reservation;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\BookReservationRequest;
use App\Models\Reservations\ReservationRequest;
use Google\Service\Compute\Resource\Reservations;
use App\Http\Controllers\PushNotificationController;
use App\Http\Tasks\Merged\Reservations\BookReservationTask;
use App\Http\Tasks\Merged\Reservations\GetMyReservationsTask;
use App\Http\Tasks\Merged\Reservations\GetReservationTypesTask;
use App\Http\Tasks\Reservations\GetLawyersByMainCategoryIdTask;
use App\Http\Tasks\Merged\Reservations\GetReservationRequestsTask;
use App\Http\Tasks\Merged\Reservations\GetReservationConnTypesTask;
use App\Http\Tasks\Merged\Lawyer\GetLawyerAvailableReservationsTask;
use App\Http\Tasks\Merged\Reservations\ConfirmReservationEndingTask;
use App\Http\Tasks\Merged\Reservations\GetAvailableReservationsTask;
use App\Http\Tasks\Merged\Reservations\GetMyReservationsTaskFromYmtaz;
use App\Http\Tasks\Merged\Reservations\GetReservationTypesTaskForLawyer;
use App\Http\Tasks\Merged\Reservations\GetLawyersByReservationTypeIdTask;
use App\Http\Tasks\Merged\Reservations\GetReservationTypesForPricingTask;
use App\Http\Tasks\Merged\Reservations\GetMyReservationsTaskFromDigitalGuide;
use App\Http\Tasks\Merged\Reservations\ConfirmReservationStartTask;
use Illuminate\Support\Facades\Crypt;

class ReservationsController extends BaseController
{
    public function getAvailableReservations(Request $request, GetAvailableReservationsTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getReservationTypes(Request $request, GetReservationTypesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getLawyersByMainCategoryId(Request $request, $rti_id, GetLawyersByMainCategoryIdTask $task)
    {
        $response = $task->run($request, $rti_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getReservationTypesForLawyer(Request $request, GetReservationTypesTaskForLawyer $task, $lawyer_id)
    {
        $response = $task->run($request, $lawyer_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getReservationConnectionTypes(Request $request, GetReservationConnTypesTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getLawyerReservations(Request $request, GetLawyerAvailableReservationsTask $task, $id)
    {
        $response = $task->run($id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function createReservationRequest(BookReservationRequest $request, BookReservationTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function getReservationRequests(Request $request, GetReservationRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function replyToOffer(Request $request)
    {
        $client = $this->authAccount();
      
// dd($client->type);
        $offer = ReservationRequest::where('id', $request->offer_id)
            ->where('account_id', $client->id)
            ->where('status', operator: 'pending-acceptance')
            ->firstOrFail();


            // dd($offer);

        if ($request->action == 'accept') {
            // $offer->status = 'accepted';
            $offer->save();
           
            // Cancel other offers for the same reservation type id and importance id
            ReservationRequest::where('reservation_type_id', $offer->reservation_type_id)
                ->where('importance_id', $offer->importance_id)
                ->where('status', 'pending-offer')->orWhere('status', 'pending-acceptance')
                ->where('account_id', $client->id)
                ->where('id', '!=', $offer->id)
                ->update(['status' => 'cancelled-by-client']);

            // Create a reservation using ServicesReservations model
            $service_request = Reservation::create([
                "reservation_type_id" => $offer->reservation_type_id,
                "importance_id" => $offer->importance_id,
                "reserved_from_lawyer_id" => $offer->lawyer_id,
                'hours' => $offer->hours,
                'region_id' => $offer->region_id,
                'city_id' => $offer->city_id,
                'longitude' => $offer->longitude,
                'latitude' => $offer->latitude,
                'lawyer_longitude' => $offer->lawyer_longitude,
                'lawyer_latitude' => $offer->lawyer_latitude,
                'day' => $offer->day,
                'from' => $offer->from,
                'to' => $offer->to,
                "account_id" => $client->id,
                "description" => $offer->description,
                'price' => $offer->price,
                'transaction_complete' => 0,
                'request_status' => 1,
                'reservation_code' => GenerateReferralCode(6),
                'offer_id' => $offer->id,
            ]);

            // Handle payment
            $Domain = route('site.index');
            $splittedName = explode(' ', $client->name);
            $firstName = $splittedName[0];
            $lastName = $splittedName[count($splittedName) - 1];
            $orderNumber = "ORD-APP-" . $service_request->id;

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
            //     "term_url_3ds" => $Domain . '/api/payments/callback/account/reservations/' . $service_request->id,
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

            // if ($results === false) {
            //     throw new \Exception(curl_error($ch), curl_errno($ch));
            // }
            // curl_close($ch);

            // $results = json_decode($results, true);


            $data = [
                'amount' => $service_request->price,
                'currency' => 'SAR',
                'description' => 'Order for a customer',
                'userId' => $client->id,
                'serviceId' => $service_request->id,
                'serviceCate'=>'reservation',
                'requester_type' =>'account',
                'orderNumber'=> $orderNumber,
            ];
            $encryptedData = Crypt::encrypt(json_encode($data));





        
            $transaction_id = $orderNumber;
            $payment_url = route('makePayment-form', ['data' => $encryptedData]);
            // dd( $payment_url);
            // Update service request with transaction details
            $service_request->update([
                'transaction_id' => $transaction_id,
            ]);

            // Create LawyerPayments record
            LawyerPayments::create([
                'account_id' => $offer->lawyer_id,
                'product_id' => $service_request->id,
                'product_type' => 'reservation',
             
                'requester_type' =>'client',
            ]);

            // Notify lawyer about the accepted offer
            $notification = Notification::create([
                'title' => "قبول العرض",
                "description" => "تم قبول عرضك من قبل العميل.",
                "type" => "offer-reservation-lawyer",
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
                'reservation' => $service_request,
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
                "type" => "offer-reservation-lawyer",
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
    public function lawyerGetReservationRequests(Request $request, LawyerGetReservationRequestsTask $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }
    public function replyWithOffer(Request $request)
    {
        $lawyer = $this->authAccount();

        $offer = ReservationRequest::where('id', $request->offer_id)
            ->where('lawyer_id', $lawyer->id)
            ->where('status', 'pending-offer')
            ->first();

        if (!$offer) {
            return $this->sendResponse(false, 'Unauthorized access.', null, 403);
        }

        $offer->price = $request->price;
        $offer->lawyer_longitude = $request->longitude;
        $offer->lawyer_latitude = $request->latitude;
        $offer->status = 'pending-acceptance';
        $offer->save();

        // Notify client about the new offer
        $notification = Notification::create([
            'title' => "عرض جديد",
            "description" => "تم تقديم عرض جديد من المحامي.",
            "type" => "offer-reservation",
            "type_id" => $offer->id,
            "account_id" => $offer->account_id,
        ]);
        $fcms = AccountFcm::where('account_id', $notification->account_id)->pluck('fcm_token')->toArray();
        if (count($fcms) > 0) {
            $notificationController = new PushNotificationController;
            $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
        }

        return $this->sendResponse(true, 'Offer updated successfully.', ['offer' => $offer], 200);
    }
    public function getMyReservations(Request $request, GetMyReservationsTaskFromYmtaz $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }
    public function getMyReservationsFromDigitalGuide(Request $request, GetMyReservationsTaskFromDigitalGuide $task)
    {
        $response = $task->run($request);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);

    }

    public function getReservationTypesForPricing(Request $request, GetReservationTypesForPricingTask $task)
    {
        $response = $task->run();
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function getLawyersByReservationTypeId(Request $request, $reservation_type_id, GetLawyersByReservationTypeIdTask $task)
    {
        $response = $task->run($request, $reservation_type_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

    public function confirmReservationStart(Request $request, $reservation_id, ConfirmReservationStartTask $task)
    {
        $response = $task->run($request, $reservation_id);
        return $this->sendResponse($response['status'], $response['message'], $response['data'], $response['code']);
    }

}