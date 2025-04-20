<?php

namespace App\Http\Tasks\Merged\Lawyer;

use App\Http\Tasks\BaseTask;
use App\Models\Service\Service;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class GetLawyerServicesTask extends BaseTask
{

    public function run($id)
    {
        $lawyerServicesPrices = Service::whereHas('lawyerPrices', function ($query) use ($id) {
            $query->where(['account_id' => $id, "isHidden" => false]);
        })->with([
                    'lawyerPrices' => function ($query) use ($id) {
                        $query->where('account_id', $id)
                            ->with('importance');
                    }
                ])->get();
        $lawyerServices = LawyerServicesPriceResource::collection($lawyerServicesPrices);
        return $this->sendResponse(true, 'Available Services for lawyer', compact('lawyerServices'), 200);
    }
}
