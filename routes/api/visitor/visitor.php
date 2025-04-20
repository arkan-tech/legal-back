<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Services\ServicesController;
use App\Http\Controllers\API\Client\Library\ClientLibraryController;
use App\Http\Controllers\API\Visitor\Profile\VisitorDeviceController;
use App\Http\Controllers\API\Visitor\Library\ClientJudicialBlogsController;
use App\Http\Controllers\API\Client\Reservations\ClientReservationsController;
use App\Http\Controllers\API\Visitor\Services\VisitorServicesRequestsController;
use App\Http\Controllers\API\Visitor\Library\ClientRulesAndRegulationsController;
use App\Http\Controllers\API\Client\AdvisoryServices\ClientAdvisoryServicesController;


Route::group(['prefix' => 'services-request'], function () {
    Route::post('/', [VisitorServicesRequestsController::class, 'create']);
});

Route::group(['prefix' => 'library'], function () {
    Route::get('/categories', [ClientLibraryController::class, 'getAllLibraryCategories']);
    Route::get('/sub-category/{id}', [ClientLibraryController::class, 'getSubCategoryLibrary']);
    Route::get('/sub-category/books/{id}', [ClientLibraryController::class, 'getBooksBaseSubCategoryId']);
    Route::get('/book/details/{id}', [ClientLibraryController::class, 'getBooksDetailsBaseId']);
    Route::post('/book/filter', [ClientLibraryController::class, 'getBooksBaseFilter']);
    Route::group(['prefix' => 'rules-regulations'], function () {
        Route::get('/', [ClientRulesAndRegulationsController::class, 'getAllRulesAndRegulations']);
        Route::get('/{id}', [ClientRulesAndRegulationsController::class, 'getRulesAndRegulationsData']);
        Route::get('search-base-cat-id/{id}', [ClientRulesAndRegulationsController::class, 'getRulesAndRegulationsBaseSubCategoryId']);
        Route::post('filter', [ClientRulesAndRegulationsController::class, 'getAllRulesAndRegulationsBaseFilter']);
    });

    Route::group(['prefix' => 'judicial-blogs'], function () {
        Route::get('/', [ClientJudicialBlogsController::class, 'getAllJudicialBlogs']);
        Route::get('/{id}', [ClientJudicialBlogsController::class, 'getJudicialBlogsData']);
        Route::get('search-base-cat-id/{id}', [ClientJudicialBlogsController::class, 'getJudicialBlogsBaseSubCategoryId']);
        Route::post('filter', [ClientJudicialBlogsController::class, 'getAllJudicialBlogsBaseFilter']);
    });

});

Route::post('create-device', [VisitorDeviceController::class, 'CreateDevice'])->middleware('auth:api_client');
Route::post('delete-device/{device_id}', [VisitorDeviceController::class, 'DeleteDevice'])->middleware('auth:api_client');



//
//        Route::post('/test-payment',function (){
//
//            $curl = curl_init();
//            curl_setopt_array($curl, [
//                CURLOPT_URL => "https://secure.telr.com/gateway/order.json",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => "",
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 30,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => "POST",
//                CURLOPT_POSTFIELDS => json_encode([
//                    'method' => 'create',
//                    'store' => 1234,
//                    'authkey' => 'mykey1234',
//                    'framed' => 0,
//                    'order' => [
//                        'cartid' => '1234',
//                        'test' => '1',
//                        'amount' => '10.50',
//                        'currency' => 'SAR',
//                        'description' => 'My purchase'
//                    ],
//                    'return' => [
//                        'authorised' => 'https://www.mysite.com/authorised',
//                        'declined' => 'https://www.mysite.com/declined',
//                        'cancelled' => 'https://www.mysite.com/cancelled'
//                    ]
//                ]),
//                CURLOPT_HTTPHEADER => [
//                    "Content-Type: application/json",
//                    "accept: application/json"
//                ],
//            ]);
//
//            $response = curl_exec($curl);
//            $err = curl_error($curl);
//
//            curl_close($curl);
//
//            if ($err) {
//                return response()->json([
//                    'status'=>true ,
//                    'data'=> "cURL Error #:" . $err
//                ]);
//
//            } else {
//                return response()->json([
//                    'status'=>true ,
//                    'data'=> $response
//                ]);
//            }
//        });
//
