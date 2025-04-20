<?php

namespace App\Http\Tasks\Lawyer\LawyerAdvisoryServices;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
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
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategoryPrice;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesTypesResource;
use App\Http\Resources\API\AdvisoryServices\AdvisoryServicesPricesResource;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;

class GetAvailableServicesForPricingTask extends BaseTask
{
    public function run(Request $request)
    {
        $lawyer = Account::find(auth()->user()->id);

        $subCategories = AdvisoryServicesSubCategory::with([
            'prices' => function ($query) {
                $query->whereNull('lawyer_id')
                    ->with('importance');
            },
        ])->get();

        $subCategories->each(function ($subCategory) use ($lawyer) {
            $subCategory['ymtazPrices'] = $subCategory->prices()->whereNull('lawyer_id')->get()->map(function ($price) {
                return [
                    'id' => $price->id,
                    'price' => $price->price,
                    'duration' => $price->duration,
                    'isHidden' => $price->isHidden,
                    'level' => [
                        'id' => $price->importance->id,
                        'name' => $price->importance->title,
                    ],
                ];
            });

            unset($subCategory->prices);

            $lawyerPrices = AdvisoryServicesSubCategoryPrice::where('lawyer_id', $lawyer->id)
                ->where('sub_category_id', $subCategory->id)
                ->get();

            $isActivated = $lawyerPrices->isNotEmpty();
            $subCategory['is_activated'] = $isActivated;
            $subCategory['isHidden'] = $lawyerPrices->count() > 0 ? $lawyerPrices->some(function ($price) {
                return $price->is_hidden;
            }) : null;

            if ($isActivated) {
                $subCategory['lawyerPrices'] = $lawyerPrices->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'price' => $price->price,
                        'duration' => $price->duration,
                        'isHidden' => $price->is_hidden,
                        'level' => [
                            'id' => $price->importance->id,
                            'name' => $price->importance->title,
                        ],
                    ];
                });
            } else {
                $subCategory['lawyerPrices'] = [];
            }
        });

        return $this->sendResponse(true, 'Fetched Successfully', $subCategories, 200);
    }
}
