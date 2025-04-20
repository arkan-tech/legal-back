<?php

namespace App\Http\Tasks\Merged\Reservations;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\AccountFcm;
use App\Http\Tasks\BaseTask;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\LawyerPayments;
use App\Models\API\Splash\Splash;
use App\Models\LawyerPayoutRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Devices\ClientFcmDevice;
use App\Models\Devices\LawyerFcmDevice;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationType;
use App\Http\Requests\BookReservationRequest;
use App\Models\Reservations\ReservationRequest;
use App\Http\Resources\API\Splash\SplashResource;
use App\Models\Reservations\AvailableReservation;
use App\Http\Controllers\PushNotificationController;
use App\Models\Reservations\ReservationTypeImportance;
use App\Http\Resources\API\Reservations\ReservationResource;
use App\Http\Resources\API\Reservations\AvailableReservationResource;

class BookReservationTask extends BaseTask
{

    public function run(BookReservationRequest $request)
    {
        $user = $this->authAccount();

        $validated = $request->all();

        $reservationType = ReservationType::where('id', $validated['reservation_type_id'])
            ->firstOrFail();
        // $reservationTypeImportance = ReservationTypeImportance::where('reservation_importance_id', $validated['reservation_importance_id'])
        //     ->where('reservation_types_id', $validated['reservation_type_id'])
        //     ->firstOrFail();

        $date = Carbon::parse($validated['date'])->toDateString();
        $from = Carbon::parse($validated['date'] . ' ' . $validated['from']);
        // $to = Carbon::parse($validated['date'] . ' ' . $validated['to']);
        $hours = (int) $validated['hours'];
        // Auto calculate the to from the from and hours
        $to = $from->copy()->addHours($hours);
        foreach ($request->lawyer_ids as $lawyer_id) {
            if ($this->isTimeSlotReserved($from, $to, $date, $lawyer_id)) {
                return $this->sendResponse(false, 'Time slot is already booked for lawyer ID: ' . $lawyer_id, null, 400);
            }

            $reservation = ReservationRequest::create([
                "reservation_type_id" => $reservationType->id,
                "importance_id" => $validated['importance_id'],
                "lawyer_id" => $lawyer_id,
                'hours' => $hours,
                'region_id' => $validated['region_id'],
                'city_id' => $validated['city_id'],
                'longitude' => $validated['longitude'],
                'latitude' => $validated['latitude'],
                'day' => $date,
                'from' => $from,
                'to' => $to,
                "account_id" => $user->id,
                "description" => $request->description,
            ]);

            if ($request->hasFile('file')) {
                $reservation->file = saveImage($request->file('file'), 'uploads/appointments/');
                $reservation->save();
            }

            // // $Domain = route('site.index');
            // // $params = array(
            // //     'ivp_method' => 'create',
            // //     'ivp_store' => '26601 - Ymtaz Company',
            // //     'ivp_authkey' => '5X5Rx~C2wF@pZrKP',
            // //     'ivp_cart' => 'ymtaz - cc - 12341231d542757' . rand(1, 400),
            // //     'ivp_test' => '1',
            // //     'ivp_amount' => $reservationTypeImportance->price * $hours,
            // //     'ivp_currency' => 'SAR',
            // //     'ivp_desc' => "New Payment Proccess From Ymtaz Website.",
            // //     'ivp_framed' => 1,
            // //     'bill_country' => 'SA',
            // //     'bill_email' => $user->email,
            // //     'bill_fname' => $user->name,
            // //     'bill_sname' => $user->name,
            // //     'bill_city' => 'City',
            // //     'bill_addr1' => 'City',
            // //     'return_auth' => $Domain . '/api/payments/callback/account/reservations/' . $reservation->id,
            // //     'return_can' => $Domain . '/api/payments/callback/account/reservations/' . $reservation->id,
            // //     'return_decl' => $Domain . '/api/payments/callback/account/reservations/' . $reservation->id,

            // // );

            // $ch = curl_init();
            // curl_setopt($ch, CURLOPT_URL, "https://secure.telr.com/gateway/order.json");
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

            // $reservation->update([
            //     'transaction_id' => $results['order']['ref'],
            // ]);

            // $transaction_id = $results['order']['ref'];
            // $payment_url = $results['order']['url'];

            // if (!is_null($lawyer_id)) {
            //     LawyerPayments::create([
            //         "account_id" => $lawyer_id,
            //         "product_id" => $reservation->id,
            //         "product_type" => "reservation",
            //         'requester_type' => "account"
            //     ]);
            // }

            // $httpClient = new Client();
            // $jsonData = [
            //     "userId" => $user->id,
            //     "lawyerId" => $lawyer_id,
            //     "productId" => $reservation->id,
            //     "productType" => 1
            // ];
            // $httpRequest = $httpClient->postAsync(env('JS_API_URL') . 'get-stream/', [
            //     'json' => $jsonData
            // ]);
            // $response = $httpRequest->wait();
            // \Log::info($response->getBody());

            // $reservation = Reservation::find($reservation->id);
            // $time_difference = null;
            // $show_call_id = false;
            // if (!is_null($reservation->from)) {
            //     $from = Carbon::parse($reservation->from);
            //     $to = Carbon::parse($reservation->to);
            //     $current_datetime = Carbon::now();
            //     $time_difference = $from->diffForHumans($to, true);
            //     $show_call_id = $current_datetime->between($from, $to);
            // }
            // $reservation['call_id'] = $reservation->call_id;
            // $reservation['appointment_duration'] = $time_difference;
        }

        return $this->sendResponse(true, 'Reservation Created', compact('reservation'), 201);
    }

    protected function isTimeSlotReserved($start, $end, $date, $lawyer_id)
    {
        $reservations = Reservation::where('day', $date)->where('reserved_from_lawyer_id', $lawyer_id)->get();
        \Log::info('Checking time slot reservation', [
            'start' => $start->format('Y-m-d H:i:s'),
            'end' => $end->format('Y-m-d H:i:s'),
            'reservation_count' => $reservations->count(),
        ]);
        foreach ($reservations as $reservation) {
            $resFrom = Carbon::parse($date . ' ' . Carbon::parse($reservation->from)->format('H:i:s'));
            $resTo = Carbon::parse($date . ' ' . Carbon::parse($reservation->to)->format('H:i:s'));
            $isBetween = $start->between($resFrom, $resTo) || $end->between($resFrom, $resTo) || $resFrom->between($start, $end) || $resTo->between($start, $end);
            \Log::info('Checking against reservation', [
                'res_from' => $resFrom->format('Y-m-d H:i:s'),
                'res_to' => $resTo->format('Y-m-d H:i:s'),
            ]);
            if ($isBetween) {
                if ($reservation->transaction_complete != 0) {
                    return true;
                }
            }
        }

        return false;
    }
}
