<?php

namespace App\Http\Tasks\Merged\Payments;

use App\Models\Account;
use App\Models\AccountFcm;
use App\Models\AdvisoryServicesReservations;
use App\Models\EliteServiceRequest;
use App\Models\Invoice;
use App\Models\Reservations\ReservationRequest;
use App\Models\Service\ServiceUser;
use App\Models\ServicesReservations;
use GuzzleHttp\Client;
use App\Models\Activity;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\API\Splash\Splash;
use App\Models\Client\ClientRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Reservations\Reservation;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Controllers\PushNotificationController;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Http\Resources\API\Reservations\AvailableReservationResource;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;
use App\Models\Packages\PackageSubscription;
use App\Models\EliteServiceRequestsProductOffer;

class PaymentCallbackTask extends BaseTask
{
    private $client;
    public function __construct()
    {
        $this->client = new Client();
    }
    public function checkTransaction($transaction_id)
    {


        $transaction = Invoice::where('order_number', $transaction_id)->first();
        $transaction =   $transaction->transaction_id;
        // dd($transaction_id, $transaction );

        $response = \Illuminate\Support\Facades\Http::withBasicAuth(env('MOYASAR_API_KEY'), '') // الباسورد فاضي زي ما Moyasar طالبة
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-Forwarded-For' => $clientIp ?? request()->ip(),
            ])
            ->post('https://api.moyasar.com/v1/payments/{$transaction}');

        $status = $response->status();

        dd($response, $transaction);
        if ($response->getStatusCode() == 200) {

            $responseBody = $response->getBody();
            $responseBody = json_decode($responseBody);
            dd($responseBody);
            if ($responseBody->responseBody->status == "settled") {
                return "Paid";
            } else if ($responseBody->responseBody->status == "decline") {
                return "Declined";
                // } else if ($responseBody->responseBody->status == 2) {
                //     return "On Hold";

                // } else if ($responseBody->responseBody->status == 1) {
                //     return false; // Pending

                // } else if ($responseBody->responseBody->status == -1) {
                //     return false; // Expired
                // } else if ($responseBody->responseBody->status == -2) {
                //     return false; // Cancelled
            } else {
                return false; // Any other
            }
        } else {
            return false;
        }
        // return "Paid";
    }

    /**
     * Returns Object
     */
    public function returnResponse($model, $transactionStatus, $isReservation = false)
    {
        if (!$model) {
            return response()->json([
                'message' => 'هذه العملية مفقودة أو غير مسجلة، برجاء إعادة المحاولة أو تكرار العملية لاحقًا.',
            ], 404);
        }
        

        if ($transactionStatus == "paid") {
            $model->update([
                'transaction_complete' => 1,
            ]);
            return view('site.api.completePayment');
        } else if ($transactionStatus == "failed") {
            $model->update([
                'transaction_complete' => 3
            ]);
            return view('site.api.declinedPayment');
        } else if ($transactionStatus == "On Hold") {
            if ($model->transaction_complete == 0) {
                $model->update([
                    'transaction_complete' => 4
                ]);
            }
            return view('site.api.onHoldPayment');
        } else {
            if ($isReservation) {
                $model->delete();
            }
            $model->update([
                'transaction_complete' => 2
            ]);
            return view('site.api.cancelPayment');
        }
    }

    private function calculateEndDate($subscription)
    {
        $startDate = now();
        switch ($subscription->package->duration_type) {
            case 1:
                return $startDate->addDays($subscription->package->duration);
            case 2:
                return $startDate->addWeeks($subscription->package->duration);
            case 3:
                return $startDate->addMonths($subscription->package->duration);
            case 4:
                return $startDate->addYears($subscription->package->duration);
            default:
                return null;
        }
    }

    public function run(Request $request)
    {


        $id = $request->query('id');
        $status = $request->query('status');
        $amount = $request->query('amount');
        $message = $request->query('message');
        $callbackInfo =  Invoice::where('transaction_id', $id)->first();
        $type = $callbackInfo->requester_type ?? 'client';
        $service = $callbackInfo->serviceCate;
        $accountId = $callbackInfo->user_id;
        // $id = $callbackInfo->service;
        $account = Account::find($accountId);
        $id = $callbackInfo->order_number;
        $trans_action = Invoice::where('order_number', $id)->first();
        if ($status === "paid") {
            $trans_action->status = 'paid';
        } else {
            $trans_action->status = 'failed';
        }

        // dd(
            
            
        // $message ,
        // $id , $status , $amount,$callbackInfo,$type , $service , $accountId , $account , $trans_action
        // );
   
        $trans_action->save();
        if ($type == "account"||$type == "client") {
       
            if ($service == "service"||$service == "services") {
        //    dd('here');
                $LawyerServicesRequest = ServicesReservations::where('transaction_id', $id)->first();
                // dd( $LawyerServicesRequest);
                $oldStatus = $LawyerServicesRequest->transaction_complete?? 0;
                $transactionStatus =  $status;
                $returnResponse = $this->returnResponse($LawyerServicesRequest, $transactionStatus);
                $urlWithParams = url()->current() . '?status=' . strtolower($transactionStatus);
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $notification = Notification::create([
                            'title' => "حجز خدمة",
                            "description" => "تم حجز الخدمة بنجاح",
                            "type" => "service",
                            "type_id" => $LawyerServicesRequest->id,
                            "account_id" => $LawyerServicesRequest->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($LawyerServicesRequest->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);

                        $fcms = AccountFcm::where('account_id', $LawyerServicesRequest->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز خدمة", "تم حجز الخدمة بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                        if (!is_null($LawyerServicesRequest->reserved_from_lawyer_id)) {
                            $notification = Notification::create([
                                'title' => "حجز خدمة من مقدم خدمة",
                                "description" => "تم حجز خدمة من مقدم خدمة لك بنجاح",
                                "type" => "service-lawyer",
                                "type_id" => $LawyerServicesRequest->id,
                                "account_id" => $LawyerServicesRequest->reserved_from_lawyer_id,
                            ]);
                            $fcms = AccountFcm::where('account_id', $LawyerServicesRequest->reserved_from_lawyer_id)->pluck('fcm_token')->toArray();
                            if (count($fcms) > 0) {
                                $notificationController = new PushNotificationController;
                                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
                            }
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else if ($service == "advisory-service") {
                //   dd('here',$service);
                $LawyerAdvisoryServicesReservations = AdvisoryServicesReservations::where('transaction_id', $id)->first();;
                $oldStatus = $LawyerAdvisoryServicesReservations->transaction_complete?? 0;
                $transactionStatus = $status;
                $urlWithParams = url()->current() . '?status=' . strtolower($transactionStatus);
                $returnResponse = $this->returnResponse($LawyerAdvisoryServicesReservations, $transactionStatus);
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $notification = Notification::create([
                            'title' => "حجز استشارة",
                            "description" => "تم حجز الاستشارة بنجاح",
                            "type" => "advisory_service",
                            "type_id" => $LawyerAdvisoryServicesReservations->id,
                            "account_id" => $LawyerAdvisoryServicesReservations->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($LawyerAdvisoryServicesReservations->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
                        $fcms = AccountFcm::where('account_id', $LawyerAdvisoryServicesReservations->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز استشارة", "تم حجز الاستشارة بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                        if (!is_null($LawyerAdvisoryServicesReservations->reserved_from_lawyer_id)) {
                            $notification = Notification::create([
                                'title' => "حجز استشارة من مقدم خدمة",
                                "description" => "تم حجز حجز استشارة من مقدم خدمة لك بنجاح",
                                "type" => "advisory_service-lawyer",
                                "type_id" => $LawyerAdvisoryServicesReservations->id,
                                "account_id" => $LawyerAdvisoryServicesReservations->reserved_from_lawyer_id,
                            ]);
                            $fcms = AccountFcm::where('account_id', $LawyerAdvisoryServicesReservations->reserved_from_lawyer_id)->pluck('fcm_token')->toArray();
                            if (count($fcms) > 0) {
                                $notificationController = new PushNotificationController;
                                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
                            }
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else if ($service == "reservation") {
                $reservationRequest = Reservation::where('transaction_id', $id)->first();
                // dd($reservationRequest);
                $oldStatus = $reservationRequest->transaction_complete ?? 0;
                $transactionStatus =  $status;
                $returnResponse = $this->returnResponse($reservationRequest, $transactionStatus, true);
                $urlWithParams = url()->current() . '?status=' . strtolower($transactionStatus);
                
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $notification = Notification::create([
                            'title' => "حجز الموعد",
                            "description" => "تم حجز الموعد بنجاح",
                            "type" => "appointment",
                            "type_id" => $reservationRequest->id,
                            "account_id" => $reservationRequest->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($reservationRequest->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
                        $fcms = AccountFcm::where('account_id', $reservationRequest->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز الموعد", "تم حجز الموعد بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                        if (!is_null($reservationRequest->reserved_from_lawyer_id)) {
                            $notification = Notification::create([
                                'title' => "حجز موعد من مقدم خدمة",
                                "description" => "تم حجز حجز موعد من مقدم خدمة لك بنجاح",
                                "type" => "appointment-lawyer",
                                "type_id" => $reservationRequest->id,
                                "account_id" => $reservationRequest->reserved_from_lawyer_id,
                            ]);
                            $fcms = AccountFcm::where('account_id', $reservationRequest->reserved_from_lawyer_id)->pluck('fcm_token')->toArray();
                            if (count($fcms) > 0) {
                                $notificationController = new PushNotificationController;
                                $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
                            }
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else if ($service == "package") {
                $packageSubscription = PackageSubscription::where('transaction_id', $id)->first();
                $transactionStatus =  $status;
                $returnResponse = $this->returnResponse($packageSubscription, $transactionStatus);
                $urlWithParams = url()->current() . '?status=' . strtolower($transactionStatus);
                if ($packageSubscription->transaction_complete == 0 || $packageSubscription->transaction_complete == 4) {
                    if ($transactionStatus == "Paid") {
                        PackageSubscription::where('account_id', $packageSubscription->account_id)->where('id', "!=", $packageSubscription->id)->delete();
                        $packageSubscription->update([
                            'start_date' => now()->toDateString(),
                            'end_date' => $this->calculateEndDate($packageSubscription)->toDateString()
                        ]);
                        $notification = Notification::create([
                            'title' => "اشتراك باقة",
                            "description" => "تم شراء الباقة بنجاح",
                            "type" => "package",
                            "type_id" => $packageSubscription->id,
                            "account_id" => $packageSubscription->account_id,
                        ]);
                        $fcms = AccountFcm::where('account_id', $packageSubscription->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification(
                                $fcms,
                                $notification->title,
                                $notification->description,
                                ["type" => $notification->type, "type_id" => $notification->type_id]
                            );
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else {
                return abort(404);
            }
        } else if ($type = "elite-service") {
            $eliteServiceRequest = EliteServiceRequest::findOrFail($id);
            $oldStatus = $eliteServiceRequest->transaction_complete;
            $transactionStatus = $this->checkTransaction($eliteServiceRequest->transaction_id);
            $returnResponse = $this->returnResponse($eliteServiceRequest, $transactionStatus);
            $urlWithParams = url()->current() . '?status=' . strtolower($transactionStatus);
            if ($service == "service") {
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $serviceReservation = ServicesReservations::create([
                            "elite_service_request_id" => $eliteServiceRequest->id,
                            'type_id' => $eliteServiceRequest->offers()->service_sub_id,
                            'for_admin' => 1,
                            'transaction_id' => $eliteServiceRequest->transaction_id,
                            'account_id' => $eliteServiceRequest->account_id,
                            'description' => $eliteServiceRequest->description ?? '',
                            'price' => $eliteServiceRequest->offers()->service_sub_price,
                            'accept_rules' => 1,
                            'transaction_complete' => 0,
                            'status' => 1,
                            'request_status' => 1,
                        ]);
                        $notification = Notification::create([
                            'title' => "حجز خدمة",
                            "description" => "تم حجز الخدمة بنجاح",
                            "type" => "service",
                            "type_id" => $serviceReservation->id,
                            "account_id" => $serviceReservation->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($serviceReservation->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);

                        $fcms = AccountFcm::where('account_id', $serviceReservation->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز خدمة", "تم حجز الخدمة بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                        // TODO: Send notification to advisory
                        // if (!is_null($serviceReservation->reserved_from_lawyer_id)) {
                        //     $notification = Notification::create([
                        //         'title' => "حجز خدمة من مقدم خدمة",
                        //         "description" => "تم حجز خدمة من مقدم خدمة لك بنجاح",
                        //         "type" => "service-lawyer",
                        //         "type_id" => $LawyerServicesRequest->id,
                        //         "account_id" => $LawyerServicesRequest->reserved_from_lawyer_id,
                        //     ]);
                        //     $fcms = AccountFcm::where('account_id', $LawyerServicesRequest->reserved_from_lawyer_id)->pluck('fcm_token')->toArray();
                        //     if (count($fcms) > 0) {
                        //         $notificationController = new PushNotificationController;
                        //         $notificationController->sendNotification($fcms, $notification->title, $notification->description, ["type" => $notification->type, "type_id" => $notification->type_id]);
                        //     }
                        // }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else if ($service == "advisory-service") {
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $advisoryServiceReservation = AdvisoryServicesReservations::create([
                            "elite_service_request_id" => $eliteServiceRequest->id,
                            "sub_category_price_id" => $eliteServiceRequest->offers()->service_sub_id,
                            "description" => $eliteServiceRequest->description,
                            "price" => $eliteServiceRequest->offers()->service_sub_price,
                            'transaction_id' => $eliteServiceRequest->transaction_id,
                            'for_admin' => 1,
                            'request_status' => 1,
                        ]);
                        $notification = Notification::create([
                            'title' => "حجز استشارة",
                            "description" => "تم حجز الاستشارة بنجاح",
                            "type" => "advisory_service",
                            "type_id" => $advisoryServiceReservation->id,
                            "account_id" => $advisoryServiceReservation->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($advisoryServiceReservation->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
                        $fcms = AccountFcm::where('account_id', $advisoryServiceReservation->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز استشارة", "تم حجز الاستشارة بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            } else if ($service == "reservation") {
                if ($oldStatus == 0 || $oldStatus == 4) {
                    if ($transactionStatus == "Paid") {
                        $offer = $eliteServiceRequest->offers();
                        $reservationRequest = Reservation::create([
                            "elite_service_request_id" => $eliteServiceRequest->id,
                            "reservation_type_id" => $offer->reservation_type_id,
                            "description" => $eliteServiceRequest->description,
                            "price" => $offer->reservation_price,
                            'transaction_id' => $eliteServiceRequest->transaction_id,
                            'for_admin' => 1,
                            'request_status' => 1,
                            'longitude' => $offer->reservation_longitude,
                            'latitude' => $offer->reservation_latitude,
                            'day' => $offer->reservation_date,
                            'from' => $offer->reservation_from_time,
                            'to' => $offer->reservation_from_time,
                            'hours' => 1,
                        ]);
                        $notification = Notification::create([
                            'title' => "حجز الموعد",
                            "description" => "تم حجز الموعد بنجاح",
                            "type" => "appointment",
                            "type_id" => $reservationRequest->id,
                            "account_id" => $reservationRequest->account_id,
                        ]);
                        $activity = Activity::find(6);
                        $account = Account::find($reservationRequest->account_id);
                        $account->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
                        $fcms = AccountFcm::where('account_id', $reservationRequest->account_id)->pluck('fcm_token')->toArray();
                        if (count($fcms) > 0) {
                            $notificationController = new PushNotificationController;
                            $notificationController->sendNotification($fcms, "حجز الموعد", "تم حجز الموعد بنجاح", ["type" => $notification->type, "type_id" => $notification->type_id]);
                        }
                    }
                }
                if ($request->has('status')) {
                    return $returnResponse;
                }
                return redirect($urlWithParams);
            }
        }
    }
}

//TODO Convert to json output so web can use it
// TODO Add advisory service call id
// TODO Add files ot elite services requests for the