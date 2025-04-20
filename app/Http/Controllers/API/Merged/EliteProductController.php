<?php

namespace App\Http\Controllers\API\Merged;

use Illuminate\Http\Request;
use App\Models\EliteServiceRequest;
use App\Models\EliteServiceCategory;
use App\Models\EliteServiceRequestFile;
use App\Models\Service\ServiceSubCategory;
use App\Http\Controllers\API\BaseController;
use App\Models\EliteServicePricingCommittee;
use App\Http\Resources\EliteServiceRequestResource;
use App\Http\Requests\API\Merged\CreateEliteServiceRequest;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Http\Requests\API\Merged\AddEliteServicePricingRequest;
use App\Models\EliteServiceRequestsProductOffer;
use Illuminate\Support\Facades\Crypt;

class EliteProductController extends BaseController
{

    public function getCategories(Request $request)
    {
        $categories = EliteServiceCategory::get()->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        });
        return $this->sendResponse('success', 'Categories fetched successfully', compact('categories'), 200);
    }
    public function getRequests(Request $request)
    {
        $requests = EliteServiceRequest::where('account_id', $request->user()->id)->get();
        $requests = EliteServiceRequestResource::collection($requests);
        return $this->sendResponse(true, 'Requests Fetched Successfully', compact('requests'), 200);
    }
    public function getPendingPricing(Request $request)
    {
        $userId = $request->user()->id;
        $hasAccess = EliteServicePricingCommittee::where('account_id', $userId)->exists();
        if (!$hasAccess) {
            return $this->sendResponse(false, 'Forbidden', null, 403);
        }
        $pendingPricing = EliteServiceRequest::whereIn('status', ['pending-pricing', 'pending-pricing-change'])->where('pricer_account_id', $userId)->get();
        $pendingPricing = EliteServiceRequestResource::collection($pendingPricing);
        return $this->sendResponse(true, 'Pending Pricing Fetched Successfully', compact('pendingPricing'), 200);
    }
    public function addPricing(AddEliteServicePricingRequest $request)
    {
        $userId = $request->user()->id;
        $eliteServiceRequest = EliteServiceRequest::findOrFail($request->elite_service_request_id);
        if ($eliteServiceRequest->pricer_account_id != $userId) {
            return $this->sendResponse(false, 'Forbidden', null, 403);
        }
        if ($eliteServiceRequest->status != 'pending-pricing') {
            return $this->sendResponse(false, 'Request is not pending pricing', null, 400);
        }

        $advisoryServiceSub = AdvisoryServicesSubCategory::find($request->advisory_service_sub_id);
        $paymentCategoryTypeId = $advisoryServiceSub ? $advisoryServiceSub->generalCategory->paymentCategoryType->id : null;

        if ($paymentCategoryTypeId == 2) {
            if (!$request->advisory_service_date) {
                return $this->sendResponse(false, 'حقل التاريخ مطلوب.', null, 400);
            }
            if (!$request->advisory_service_from_time) {
                return $this->sendResponse(false, 'حقل وقت البدء مطلوب.', null, 400);
            }
            if (!$request->advisory_service_to_time) {
                return $this->sendResponse(false, 'حقل وقت الانتهاء مطلوب.', null, 400);
            }
        }

        $eliteServiceRequestOffers = $eliteServiceRequest->offers()->updateOrCreate([
            'elite_service_request_id' => $eliteServiceRequest->id,
            'advisory_service_sub_id' => $request->advisory_service_sub_id,
            'advisory_service_sub_price' => $request->advisory_service_sub_price,
            'advisory_service_date' => $paymentCategoryTypeId == 2 ? $request->advisory_service_date : null,
            'advisory_service_from_time' => $paymentCategoryTypeId == 2 ? $request->advisory_service_from_time : null,
            'advisory_service_to_time' => $paymentCategoryTypeId == 2 ? $request->advisory_service_to_time : null,
            'service_sub_id' => $request->service_sub_id,
            'service_sub_price' => $request->service_sub_price,
            'reservation_type_id' => $request->reservation_type_id,
            'reservation_price' => $request->reservation_price,
            'reservation_date' => $request->reservation_date,
            'reservation_from_time' => $request->reservation_from_time,
            'reservation_to_time' => $request->reservation_to_time,
            'reservation_latitude' => $request->reservation_latitude,
            'reservation_longitude' => $request->reservation_longitude,
        ]);

        $eliteServiceRequest->update([
            'status' => 'pending-pricing-approval',
        ]);

        $eliteServiceRequest = new EliteServiceRequestResource($eliteServiceRequest);
        return $this->sendResponse(true, 'Pricing Added Successfully', compact('eliteServiceRequest'), 200);
    }
    public function createRequest(CreateEliteServiceRequest $request)
    {
        $userId = $request->user()->id;

        $createdESR = EliteServiceRequest::create([
            'account_id' => $userId,
            'elite_service_category_id' => $request->elite_service_category_id,
            'description' => $request->description,
            'pricer_account_id' => getNextPricingCommitteeMember()->account_id, // Assign to next member
        ]);

        if ($request->has('files')) {
            foreach ($request->input('files') as $index => $file) {
                $fileData = $request->file("files.$index.file");
                $isVoice = $request->input("files.$index.is_voice");
                // Process each file here
                $filePath = saveImage($fileData, 'uploads/elite_service/');
                $createdESR->files()->create([
                    'file' => $filePath,
                    'is_voice' => (boolean) $isVoice,
                ]);
            }
        }
        $createdESR = new EliteServiceRequestResource($createdESR);
        return $this->sendResponse(true, 'Request Created Successfully', $createdESR, 201);
    }

    public function counterOffer(Request $request, $offerId)
    {
        $offer = EliteServiceRequestsProductOffer::findOrFail($offerId);

        $eliteServiceRequest = $offer->eliteServiceRequest;

        $offer->update([
            'advisory_service_sub_price_counter' => $request->advisory_service_sub_price_counter,
            'advisory_service_date_counter' => $request->advisory_service_date_counter,
            'advisory_service_from_time_counter' => $request->advisory_service_from_time_counter,
            'advisory_service_to_time_counter' => $request->advisory_service_to_time_counter,
            'service_sub_price_counter' => $request->service_sub_price_counter,
            'reservation_price_counter' => $request->reservation_price_counter,
            'reservation_date_counter' => $request->reservation_date_counter,
            'reservation_from_time_counter' => $request->reservation_from_time_counter,
            'reservation_to_time_counter' => $request->reservation_to_time_counter,
        ]);

        $eliteServiceRequest->update([
            'status' => 'pending-pricing-change',
        ]);

        return $this->sendResponse(true, 'Counter Offer Submitted Successfully', new EliteServiceRequestResource($eliteServiceRequest), 200);
    }

    public function approveOffer(Request $request, $offerId)
    {
        $offer = EliteServiceRequestsProductOffer::findOrFail($offerId);
        $type = $request->type;
        $price = $request->type == "advisory-service" ? $offer->advisory_service_sub_price : ($request->type == "service" ? $offer->service_sub_price : $offer->reservation_price);
        $eliteServiceRequest = $offer->eliteServiceRequest;

        $eliteServiceRequest->update([
            'status' => 'approved',
        ]);

        // Generate payment link
        $client = $request->user();
        $Domain = route('site.index');
        $splittedName = explode(' ', $client->name);
        $firstName = $splittedName[0];
        $lastName = $splittedName[count($splittedName) - 1];
        $orderNumber = "ORD-ELITE-" . $eliteServiceRequest->id;
        // $params = array(
        //     'action' => 'SALE',
        //     'edfa_merchant_id' => "05084137-f149-4fa3-bc14-492d13e3b6dd",
        //     "order_id" => $orderNumber,
        //     "order_amount" => $price,
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
        //     "term_url_3ds" => $Domain . '/api/payments/callback/elite/' . $type . '/' . $eliteServiceRequest->id,
        //     "auth" => "N",
        //     "recurring_init" => "N",
        //     "hash" => sha1(md5(strtoupper($orderNumber . $price . "SAR" . "Order for a customer" . "d6c2ea8fb0df4efa00be1014dba3c806")))
        // );

        // Initiate payment request
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
        // $transaction_id = $orderNumber;
        // $payment_url = $results['redirect_url'];

        // Update service request with transaction details



        
        $data = [
            'amount' =>  $price ,
            'description' => 'Order for a customer',
            'userId' => $client->id,
            'serviceCate'=>'Reservations',
            'serviceId' => $eliteServiceRequest->id,
            'orderNumber'=> $orderNumber,
            'requester_type' =>'account',
            
        ];
        $encryptedData = Crypt::encrypt(json_encode($data));
        $transaction_id = $orderNumber;
        $payment_url = route('payment.showForm', ['data' => $encryptedData]);

        
        $eliteServiceRequest->update([
            'transaction_id' => $transaction_id,
        ]);

        return $this->sendResponse(true, 'Offer Approved Successfully', ['payment_url' => $payment_url], 200);
    }
}