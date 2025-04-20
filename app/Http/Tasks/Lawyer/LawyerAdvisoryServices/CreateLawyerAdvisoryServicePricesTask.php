<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Http\Resources\AdvisoryServicesSubCategoriesResource;
use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Client\ClientRequest;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\LawyerServicesAvailableDate;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\Lawyer\LawyerServicesAvailableDateTime;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;

class CreateLawyerAdvisoryServicePricesTask extends BaseTask
{

    public function run(Request $request)
    {

        $lawyer = Account::find(auth()->user()->id);
        $subCategory = AdvisoryServicesSubCategory::findOrFail($request->sub_category_id);

        $hasAccess = false;
        $lawyerSectionsIds = $lawyer->lawyerDetails->SectionsRel()->pluck('section_id')->toArray();
        // foreach ($service->lawyerSections as $section) {

        //     if (in_array($section->id, $lawyerSectionsIds)) {
        //         $hasAccess = true;
        //         break;
        //     }
        // }
        // if (!$hasAccess) {
        //     return $this->sendResponse(false, 'You do not have the required sections for this advisory service', null, 400);

        // }
        // if ($service->advisoryService->need_appointment == 1) {
        //     if (!is_array($request->availableDates)) {
        //         return $this->sendResponse(false, 'Service requires an appointment', null, 400);
        //     }
        // }
        AdvisoryServicesSubCategoryPrice::where('lawyer_id', $lawyer->id)
            ->where('sub_category_id', $subCategory->id)
            ->delete();
        foreach ($request->importance as $req) {
            if ($subCategory->min_price > intval($req['price']) || intval($req['price']) > $subCategory->max_price) {
                return $this->sendResponse(false, 'Price is not between min and max price', 0, 400);
            }
            $importance = ClientReservationsImportance::findOrFail($req['id']);
            $newServicePricing = new AdvisoryServicesSubCategoryPrice();
            $newServicePricing->lawyer_id = $lawyer->id;
            $newServicePricing->sub_category_id = $subCategory->id;
            $newServicePricing->importance_id = $importance->id;
            $newServicePricing->price = intval($req['price']);
            $newServicePricing->duration = $req['duration'];
            $newServicePricing->is_hidden = boolval($req['isHidden']);
            $newServicePricing->save();
        }
        // if ($service->advisoryService->need_appointment == 1) {
        //     foreach ($request->availableDates as $available_date) {
        //         $available_date = (object) $available_date;
        //         $newServicePricingDate = new AdvisoryServicesAvailableDates();
        //         $newServicePricingDate->advisory_services_id = $newServicePricing->id;
        //         $newServicePricingDate->date = $available_date->date;
        //         $newServicePricingDate->is_ymtaz = 0;
        //         $newServicePricingDate->lawyer_id = $lawyer->id;
        //         $newServicePricingDate->save();

        //         foreach ($available_date->times as $time) {
        //             $newServicePricingDateTime = new AdvisoryServicesAvailableDatesTimes();
        //             $newServicePricingDateTime->advisory_services_id = $newServicePricing->id;
        //             $newServicePricingDateTime->advisory_services_available_dates_id = $newServicePricingDate->id;
        //             $newServicePricingDateTime->time_from = $time['from'];
        //             $newServicePricingDateTime->time_to = $time['to'];
        //             $newServicePricingDateTime->save();
        //         }
        //     }
        // }
        $lawyerId = $lawyer->id;
        // $newServicePricing = AdvisoryServicesTypes::whereHas('advisory_services_prices', function ($query) use ($lawyerId) {
        //     $query->where('account_id', $lawyerId)->where('is_ymtaz', 0);
        // })
        //     ->with(['advisory_services_prices.importance'])->with([
        //             'advisory_services_prices' => function ($query) use ($lawyerId) {
        //                 $query->where('is_ymtaz', 0)->where('account_id', $lawyerId)
        //                     ->with('importance');
        //             }
        //         ])
        //     ->find($service->id);
        $newServicePricing = AdvisoryServicesSubCategory::findOrFail($subCategory->id);
        $newServicePricing = new AdvisoryServicesSubCategoriesResource($newServicePricing);
        return $this->sendResponse(true, 'Created Successfully', $newServicePricing, 200);
    }
}
