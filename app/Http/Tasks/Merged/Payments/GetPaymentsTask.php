<?php

namespace App\Http\Tasks\Merged\Payments;


use App\Models\AdvisoryServicesReservations;
use App\Models\Packages\PackageSubscription;
use App\Models\ServicesReservations;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Reservations\Reservation;


class GetPaymentsTask extends BaseTask
{

    public function run(Request $request)
    {
        $user = $this->authAccount();

        $advisoryServices = AdvisoryServicesReservations::where('account_id', $user->id)->with('subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance')
            ->get()->map(function ($advisoryService) {
                $newObject = [];
                $newObject['transaction_id'] = $advisoryService->transaction_id;
                $newObject['payment_category_type_name'] = $advisoryService->subCategoryPrice->subCategory->generalCategory->paymentCategoryType->name;
                $newObject['main_category_name'] = $advisoryService->subCategoryPrice->subCategory->generalCategory->name;
                $newObject['name'] = $advisoryService->subCategoryPrice->subCategory->name;
                $newObject['type'] = 'advisory-service';
                $newObject['importance'] = $advisoryService->subCategoryPrice->importance->title;
                $newObject['price'] = intval($advisoryService->price);
                $newObject['created_at'] = $advisoryService->created_at;
                $newObject['transaction_complete'] = $advisoryService->transaction_complete;
                return $newObject;
            });

        $services = ServicesReservations::where('account_id', $user->id)->with('type.category', 'priorityRel')
            ->get()->map(
                function ($service) {
                    $newObject = [];
                    $newObject['transaction_id'] = $service->transaction_id;
                    $newObject['payment_category_type_name'] = null;
                    $newObject['main_category_name'] = $service->type->category->name;
                    $newObject['name'] = $service->type->title;
                    $newObject['type'] = 'service';
                    $newObject['importance'] = $service->priorityRel->title;
                    $newObject['price'] = intval($service->price);
                    $newObject['created_at'] = $service->created_at;
                    $newObject['transaction_complete'] = $service->transaction_complete;
                    return $newObject;
                }
            );
        $reservations = Reservation::where('account_id', $user->id)->with('reservationType', 'importance')
            ->get()->map(
                function ($reservation) {
                    $newObject = [];
                    $newObject['transaction_id'] = $reservation->transaction_id;
                    $newObject['payment_category_type_name'] = null;
                    $newObject['main_category_name'] = null;
                    $newObject['name'] = $reservation->reservationType->name;
                    $newObject['type'] = 'reservation';
                    $newObject['importance'] = $reservation->importance->title;
                    $newObject['price'] = intval($reservation->price);
                    $newObject['created_at'] = $reservation->created_at;
                    $newObject['transaction_complete'] = $reservation->transaction_complete;
                    return $newObject;
                }
            );
        $subscriptions = PackageSubscription::where('account_id', $user->id)->with('package')
            ->get()->map(
                function ($package) {
                    $newObject = [];
                    $newObject['transaction_id'] = $package->transaction_id;
                    $newObject['payment_category_type_name'] = null;
                    $newObject['main_category_name'] = null;
                    $newObject['name'] = $package->package->name;
                    $newObject['type'] = 'package';
                    $newObject['price'] = intval($package->package->priceAfterDiscount);
                    $newObject['importance'] = null;
                    $newObject['created_at'] = $package->created_at;
                    $newObject['transaction_complete'] = $package->transaction_complete;
                    return $newObject;
                }
            );
        $payments = array_merge($advisoryServices->toArray(), $services->toArray(), $reservations->toArray(), $subscriptions->toArray());
        usort($payments, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });
        return $this->sendResponse(true, 'Payments retrieved successfully', compact('payments'), 200);

    }
}
