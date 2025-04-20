<?php

namespace App\Http\Tasks\Merged\Packages;

use App\Http\Controllers\PushNotificationController;
use App\Models\Package\Package;
use Illuminate\Http\Request;
use App\Http\Tasks\BaseTask;
use App\Models\Packages\PackageSubscription;
use App\Models\AccountFcm;
use Illuminate\Support\Facades\Crypt;

class SubscribePackageTask extends BaseTask
{
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
        $user = $this->authAccount();


        $package = Package::findOrFail($request->package_id);
        // Create subscription
        $subscription = PackageSubscription::create([
            'package_id' => $request->package_id,
            'account_id' => $user->id,
            'transaction_id' => "",
            'transaction_complete' => 0,
        ]);
        $orderNumber = "ORD-PCKG-" . $subscription->id;
        $transaction_id = $orderNumber;
        $payment_url = null;
        if ($package->priceAfterDiscount == 0) {
            $subscription->update([
                'transaction_complete' => 1,
                'transaction_id' => $orderNumber,
                'start_date' => now(),
                'end_date' => $this->calculateEndDate($subscription),
            ]);
            return [
                'status' => true,
                'message' => 'Subscription created successfully',
                'data' => compact('subscription', 'transaction_id', 'payment_url'),
                'code' => 201
            ];
        }
        $Domain = route('site.index');
        $splittedName = explode(' ', $user->name);
        $firstName = $splittedName[0];
        $lastName = $splittedName[count($splittedName) - 1];
        // $params = array(
        //     'action' => 'SALE',
        //     'edfa_merchant_id' => "05084137-f149-4fa3-bc14-492d13e3b6dd",
        //     "order_id" => $orderNumber,
        //     "order_amount" => $package->priceAfterDiscount,
        //     "order_currency" => "SAR",
        //     "order_description" => "Order for a customer",
        //     "req_token" => "N",
        //     "payer_first_name" => $firstName,
        //     "payer_last_name" => $lastName,
        //     'payer_address' => $user->email,
        //     "payer_country" => "SA",
        //     "payer_zip" => "12221",
        //     "payer_email" => $user->email,
        //     "payer_phone" => $user->phone,
        //     "payer_ip" => "127.0.0.1",
        //     "term_url_3ds" => $Domain . '/api/payments/callback/account/package/' . $subscription->id,
        //     "auth" => "N",
        //     "recurring_init" => "N",
        //     "hash" => sha1(md5(strtoupper($orderNumber . $package->priceAfterDiscount . "SAR" . "Order for a customer" . "d6c2ea8fb0df4efa00be1014dba3c806")))
        // );
        // \Illuminate\Support\Facades\Log::info(json_encode($params));
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, "https://api.edfapay.com/payment/initiate");
        // curl_setopt($ch, CURLOPT_POST, count($params));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        // $results = curl_exec($ch);

        // if ($results === false) {
        //     throw new \Exception(curl_error($ch), curl_errno($ch));
        // }

        // curl_close($ch);
        // $results = json_decode($results, true);
        // \Illuminate\Support\Facades\Log::info($results);
        // $payment_url = $results['redirect_url'];
        
        $data = [
            'amount' => $package->priceAfterDiscount,
            'currency' => 'SAR',
            'description' => 'Order for a customer',
            'userId' => $user->id,
            'serviceId' => $subscription->id,
            'serviceCate'=>'package',
            'requester_type' =>'account',
            'orderNumber'=> $orderNumber,
        ];
        $encryptedData = Crypt::encrypt(json_encode($data));





    
        $transaction_id = $orderNumber;
        $payment_url = route('payment.showForm', ['data' => $encryptedData]);



        $subscription->update([
            'transaction_id' => $transaction_id,
        ]);

        return [
            'status' => true,
            'message' => 'Subscription created, awaiting payment confirmation',
            'data' => compact('subscription', 'transaction_id', 'payment_url'),
            'code' => 201
        ];
    }
}