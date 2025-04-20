<?php

namespace App\Http\Tasks\Lawyer\Services;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\LawyerAdditionalInfo;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\Client\ClientRequest;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\LawyerServicesAvailableDate;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Resources\API\Services\ServicesResource;
use App\Models\Lawyer\LawyerServicesAvailableDateTime;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;
use App\Http\Resources\API\ClientRequest\ClientRequestResource;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Http\Resources\API\LawyerServicesRequest\LawyerServicesRequestResource;

class LawyerGetServicesAvailableForCreationTask extends BaseTask
{
    public function run()
    {
        $lawyer = Account::find(auth()->user()->id);
        $lawyer_profile = LawyerAdditionalInfo::with('SectionsRel')->find($lawyer->lawyerDetails->id);

        $section_ids = $lawyer_profile->SectionsRel()->pluck('section_id')->toArray();
        $servicesAvailable = [];

        $services = Service::whereHas('section', function ($query) use ($section_ids) {
            $query->whereIn('section_id', $section_ids);
        })->where('isHidden', 0)->get()->unique('id');

        foreach ($services as $service) {
            $lawyerServicePrices = LawyersServicesPrice::where('account_id', $lawyer->id)
                ->where('service_id', $service->id)
                ->with('importance')
                ->get();

            $isActivated = $lawyerServicePrices->isNotEmpty();
            $serviceResource = (new ServicesResource($service))->resolve();
            $serviceResource['is_activated'] = $isActivated;
            $serviceResource['isHidden'] = $lawyerServicePrices->some(function ($lsp) {
                return $lsp->isHidden == true;
            });

            if ($isActivated) {
                $serviceResource['lawyerPrices'] = $lawyerServicePrices->map(function ($price) {
                    return [
                        'id' => $price->id,
                        'price' => $price->price,
                        'isHidden' => $price->isHidden,
                        'level' => [
                            "id" => $price->importance->id,
                            "name" => $price->importance->title,
                        ]
                    ];
                });
            } else {
                $serviceResource['lawyerPrices'] = [];
            }

            $servicesAvailable[] = $serviceResource;
        }

        return $this->sendResponse(true, 'Fetched Successfully', $servicesAvailable, 200);
    }
}
