<?php

namespace App\Http\Controllers\API\payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Invoice;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class PaymentController extends Controller
{

    public function showPaymentForm(request $request)
    {


        // $value = 'eyJpdiI6ImFwc0ZoUkdtYmlXVG9SeTR2R3lNQ1E9PSIsInZhbHVlIjoiZkMvYms5YnUycHhDcGhnRDZxTVhrQlc5UUhucGhBeUxBdnFncHdFYVhCekFtNkhWNlcwbEVwRkt1UmR6emt6bmxKcEFvRnRxMVB0ZktRMFdWcm9DSUpBNW9wWVJYWS9DTXYvNWtyaTFJM3dWRkdTNXZvZ3d1WTFtU2ZEUkZxMHdadUJDS0RrdHBaWHNFYWpzTU1iTGFEU1lJSmppYitrRXVuTlhSbDNlVEVkZnY4amFESVpQQ0ZLTTlQd1JBWUk1WllBdlRRVzhIMk5DcjdldDN2aFVXTnNIVzVETkp0azJkU1gxSWJqNk1RQkorNzl1Y00xRjlEaTZwYWlpWmlic1VlbEZ2NXNoSlZzTjhnZVRWNDk0STVCM3ROV1VTV29hSnpGeFlyZzROWlBITHI3Rk9qZXkyTnkxOEMxUWpNZmEiLCJtYWMiOiIxZDJlNjIzZTZmYzY2MWQ4MTA3OTkzYzk3YmJlNzUyNmQ3NWEyMmRhZThkZGEwZmVkOTkyZjgxZDUwZGEyMTdkIiwidGFnIjoiIn0%3D';

        // $decoded = urldecode($value);
        // $decryptedData = json_decode(Crypt::decrypt($decoded), true);
        // dd($decryptedData);

        
        $encryptedData = $request->input('data');
        $decryptedData = json_decode(Crypt::decrypt($encryptedData), true);
        // dd('stop', $decryptedData );
        try {
            // Decrypt the data
            $decryptedData = json_decode(Crypt::decrypt($encryptedData), true);

            // Now you can use the decrypted data
            $amount = $decryptedData['amount'];

            $description = $decryptedData['description'];
            $userId = $decryptedData['userId'];
            $serviceId = $decryptedData['serviceId'];
            $serviceCate = $decryptedData['serviceCate'];
            $requester_type = $decryptedData['requester_type'];
            $orderNumber = $decryptedData['orderNumber'];
            $currency = 'SAR';
            $encodedUserId = $userId;
            $encodedRefId = $serviceId;
            $encodedAmount = $amount;
            $encodedCurrency = $currency;
            $encodedDescription = $description;
            $encodedserviceId = $serviceId;
            // $encodedCallbackUrl = encrypt($callbackUrl);
            // $user = Auth::user();

            // إذا لم يكن هناك مستخدم مسجل دخول، ستعيد استجابة خطأ
            // if (!$user) {
            //     return response()->json(['error' => 'User not authenticated'], 401);
            // }
            return view('payment-getway-form', compact(
                'encodedAmount',
                'encodedCurrency',
                'encodedDescription',
                'encodedUserId',
                'encodedserviceId',
                'serviceCate',
                'orderNumber',
                'requester_type'

            ));
        } catch (\Exception $e) {
            // Handle decryption errors (invalid or tampered data)
            return response()->json(['error' => 'Invalid or tampered data'], 400);
        }
    }

    public function makePayment(Request $request)
    {

        // try {
        $encryptedData = $request->input('data');
        $iv = $request->input('iv');

        $key = '12345678901234567890123456789012'; // نفس المفتاح في JS

        $decrypted = openssl_decrypt(
            base64_decode($encryptedData),
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            base64_decode($iv)
        );

        $data = json_decode($decrypted, true);

        // array:9 [ // app\Http\Controllers\API\payments\PaymentController.php:79
        //     "name" => "ibrahim ahmed"
        //     "card_number" => "4111111111111111"
        //     "expiry" => "12 / 34"
        //     "cvc" => "123"
        //     "amount" => "1000"
        //     "currency" => "SAR"
        //     "description" => "طلب رقم 1255"
        //     "userId" => "1"
        //     "refId" => "888"
        //   ]

        // dd( $encryptedData, $iv, $decrypted , $data);

        if (isset($data['amount'])) {
            $amount = floatval($data['amount']);
            $data['amount'] = intval($amount) == $amount ? intval($amount) : $amount;
        }
        $request->merge($data);




        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer',
            'currency' => 'required|string',
            'description' => 'required|string',
            'name' => 'required|string',
            'card_number' => 'required|string',
            'cvc' => 'required|string',
            'month' => 'required|string',
            'year' => 'required|string',
        ], [
            'amount.required' => 'يجب تحديد المبلغ.',
            'currency.required' => 'يجب تحديد العملة.',
            'description.required' => 'يجب إضافة وصف الدفع.',
            'callback_url.required' => 'يجب تحديد رابط الرجوع.',
            'name.required' => 'يجب إضافة اسم حامل البطاقة.',
            'card_number.required' => 'يجب إدخال رقم البطاقة.',
            'cvc.required' => 'يجب إدخال رقم CVC.',
            'month.required' => 'يجب تحديد شهر انتهاء البطاقة.',
            'year.required' => 'يجب تحديد سنة انتهاء البطاقة.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'هناك مشكلة في البيانات المدخلة.',
                'errors' => $validator->errors(),
            ], 400);
        }


        $clientIp = $request->ip();
        $data = [
            'amount' => $request->amount * 100,
            'currency' => $request->currency,
            'description' => $request->description,
            'callback_url' => route('callback'),

            'source' => [
                'type' => "creditcard",
                'name' => $request->name,
                'number' => $request->card_number,
                'cvc' => $request->cvc,
                'month' => $request->month,
                'year' => $request->year,
            ]
        ];
        try {
            $response = Http::withBasicAuth(env('MOYASAR_API_KEY'), '')
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Forwarded-For' => $clientIp
                ])
                ->post('https://api.moyasar.com/v1/payments', $data);

            $status = $response->status();
            $body = $response->json();
            // dd($status ,$body);
            if ($response->successful()) {
                if (isset($body['source']['transaction_url']) && !empty($body['source']['transaction_url'])) {

                    Invoice::create([
                        'user_id' => $request->userId,
                        'transaction_id' => $body['id'],
                        'status' => 'pending',
                        'amount' => $body['amount'],
                        'fees' => $body['fee'],
                        'description' => $body['description'],
                        'ip_address' => $body['ip'],
                        'service' => $request->refId,
                        'serviceCate' => $request->serviceCate,
                        'requester_type' => $request->requestertype,
                        'order_number' => $request->orderNumber,



                    ]);
// dd($request->orderNumber,'stop');
                    return response()->json([
                        'status' => true,
                        'message' => ' جاري الدفع ',
                        'redirect_url' => $body['source']['transaction_url']
                    ]);
                }


                Invoice::create([
                    'user_id' => 1,
                    'transaction_id' => $body['id'],
                    'status' => 'paid',
                    'amount' => $body['amount'],
                    'fees' => $body['fee'],
                    'description' => 'Payment for order #',
                    'ip_address' => $body['ip'],
                ]);

                return response()->json([
                    'status' => $status,
                    'message' => 'Payment initiated successfully.',

                ]);
            } elseif ($response->clientError()) {
                return response()->json([
                    'status' => $status,
                    'message' => 'There was a problem with the request. Please check your input.',
                    'data' => $body,
                ], $status);
            } elseif ($response->serverError()) {
                return response()->json([
                    'status' => $status,
                    'message' => 'Server error from Moyasar. Please try again later.',
                    'data' => $body,
                ], $status);
            } else {
                return response()->json([
                    'status' => $status,
                    'message' => 'Unexpected response from Moyasar.',
                    'data' => $body,
                ], $status);
            }
        } catch (\Exception $e) {
            Log::error('Moyasar API Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong while contacting Moyasar API.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        // This method will be called by Moyasar on the callback URL after payment completion
        $data = $request->all();

        // Check if payment was successful
        if (isset($data['status']) && $data['status'] === 'paid') {
            // Process the payment confirmation and create the invoice
            Invoice::create([
                'user_id' => 1,
                'transaction_id' => $data['id'],
                'status' => 'paid',
                'amount' => $data['amount'],
                'fees' => $data['fee'],
                'description' => 'Payment for order #' . $data['description'], // Assuming description is part of the callback data
                'ip_address' => $data['ip'],
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Payment successfully completed and invoice created.',
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Payment failed or status not recognized.',
            ]);
        }
    }
}