<?php

namespace App\Http\Tasks\Lawyer\DigitalGuidePackages;

use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Http\Resources\API\DigitalGuide\Packages\DigitalGuidePackagesResource;
use App\Http\Resources\API\DigitalGuide\Packages\SubscribeDigitalGuidePackagesResource;

class SubscribeToDigitalGuidePackageTask extends BaseTask
{

    public function run(Request $request)
    {
        $user = $this->authLawyer();
        $package = DigitalGuidePackage::where('status', 1)->where('id', $request->package_id)->first();
        if (is_null($package)) {
            return $this->sendResponse(false, 'الباقة غير متاحة', null, 404);
        }
        // not done (create)
        $Domain = route('site.index');
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => '26601 - Ymtaz Company',
            'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            'ivp_test' => '1',
            'ivp_amount' => $package->price,
            'ivp_currency' => 'SAR',
            'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            'ivp_framed' => 1,
            'bill_country' => 'SA',
            'bill_email' => $user->email,
            'bill_fname' => $user->myname,
            'bill_sname' => $user->myname,
            'bill_city' => 'City',
            'bill_addr1' => 'City',
            'return_auth' => $Domain . '/api/lawyer/digital-guide/complete/payment/' . $package->id,
            'return_can' => $Domain . '/api/lawyer/digital-guide/cancel/payment/' . $package->id,
            'return_decl' => $Domain . '/api/lawyer/digital-guide/declined/payment/' . $package->id,
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
            throw new \Exception(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);
        $results = json_decode($results, true);

        // $reservation ->update([
        //     'transaction_id' => $results['order']['ref'],
        // ]);
        // $transaction_id = $results['order']['ref'];
        $msg = ' في انتظار تأكيد الدفع';
        $package->payment_url = $results['order']['url'];
        $items = new SubscribeDigitalGuidePackagesResource($package);
        return $this->sendResponse(true, $msg, compact('items'), 200);
    }
}
