<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Client\ClientRequest;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\LawyerServicesAvailableDate;
use App\Models\Lawyer\LawyerServicesAvailableDateTime;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;

class CreateLawyerServicePricesTask extends BaseTask
{

    public function run(Request $request)
    {
        $lawyer = Account::find(auth()->user()->id);
        $service = Service::findOrFail($request->service_id);
        // if($service->need_appointment == 1){
        //     if(!is_array($request->availableDates)){
        //         return $this->sendResponse(false, 'Service requires an appointment', null, 400);
        // 	}
        // }
        LawyersServicesPrice::where('account_id', $lawyer->id)
            ->where('service_id', $service->id)
            ->delete();
        foreach ($request->importance as $req) {
            if ($service->min_price > intval($req['price']) || intval($req['price']) > $service->max_price) {
                return $this->sendResponse(false, 'Price is not between min and max price', 0, 400);
            }
            $importance = ClientReservationsImportance::findOrFail($req['id']);
            \Log::info($importance->id);
            $newServicePricing = new LawyersServicesPrice();
            $newServicePricing->account_id = $lawyer->id;
            $newServicePricing->service_id = $service->id;
            $newServicePricing->client_reservations_importance_id = $importance->id;
            $newServicePricing->price = intval($req['price']);
            $newServicePricing->isHidden = $req['isHidden'];
            $newServicePricing->save();
        }
        // if($service->need_appointment == 1){
        // 	foreach ($request->availableDates as $available_date) {
        //         $available_date = (object) $available_date;
        //         \Log::info(print_r($available_date, true));
        //         $newServicePricingDate = new LawyerServicesAvailableDate();
        //         $newServicePricingDate->service_id = $newServicePricing->id;
        //         $newServicePricingDate->date = $available_date->date;
        //         $newServicePricingDate->save();

        //         foreach ($available_date->times as $time) {
        //             $newServicePricingDateTime = new LawyerServicesAvailableDateTime();
        //             $newServicePricingDateTime->service_id = $newServicePricing->id;
        //             $newServicePricingDateTime->service_date_id = $newServicePricingDate->id;
        //             $newServicePricingDateTime->from = $time['from'];
        //             $newServicePricingDateTime->to = $time['to'];
        //             $newServicePricingDateTime->save();
        //         }
        // 	}
        // }
        $lawyerId = $lawyer->id;
        $newServicePricing = Service::whereHas('lawyerPrices', function ($query) use ($lawyerId) {
            $query->where('account_id', $lawyerId);
        })
            ->with(['lawyerPrices.importance'])->with([
                    'lawyerPrices' => function ($query) use ($lawyerId) {
                        $query->where('account_id', $lawyerId)
                            ->with('importance');
                    }
                ])
            ->find($service->id);
        return $this->sendResponse(true, 'Created Successfully', $newServicePricing, 200);
    }
}
