<?php

namespace App\Http\Tasks\Merged\Lawyer;

use App\Models\Account;
use App\Http\Tasks\BaseTask;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\Service;
use App\Models\API\Splash\Splash;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Resources\API\Lawyer\LawyerServicesPriceResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class GetNewAdvisoriesTask extends BaseTask
{

    public function run()
    {
        $newAdvisories = Account::where('status', 2)->where('account_type', 'lawyer')->whereHas('lawyerDetails', function ($query) {
            $query->where('show_in_advisory_website', 1);
        })->orderBy('created_at', 'desc')->with('city:id,title')->select(["id", "name", "profile_photo", "city_id", "gender"])->limit(20)->get();
        $newAdvisories = $newAdvisories->map(
            function ($account) {
                if (
                    !empty($account->profile_photo) || !is_null($account->profile_photo)
                ) {
                    $image = asset('uploads/account/profile_photo/' . str_replace('\\', '/', $account->profile_photo));
                } elseif ($account->gender == "Male") {

                    $image = asset('Male.png');
                } elseif ($account->gender == "Female") {
                    $image = asset('Female.png');
                } else {
                    $image = asset('uploads/person.png');
                }
                $splittedName = explode(" ", $account->name);

                $name = join(' ', [$splittedName[0], $splittedName[1], count($splittedName) == 4 ? $splittedName[3] : $splittedName[2]]);

                return [
                    'id' => $account->id,
                    'name' => $name,
                    'profile_photo' => $image,
                    'city' => $account->city,
                    'city_id' => $account->city_id
                ];
            }
        );
        return $this->sendResponse(true, 'New Advisories', compact('newAdvisories'), 200);
    }
}
