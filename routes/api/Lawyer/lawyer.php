<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Lawyer\LawyerPayoutsController;
use App\Http\Controllers\API\Client\Services\ServicesController;
use App\Http\Controllers\API\Lawyer\Device\LawyerDeviceController;
use App\Http\Controllers\API\Client\Lawyer\ClientLawyersController;
use App\Http\Controllers\API\Lawyer\Settings\LawyerSettingsController;
use App\Http\Controllers\API\Lawyer\Auth\Register\LawyerAuthController;
use App\Http\Controllers\API\Lawyer\WorkingHours\WorkingHoursController;
use App\Http\Controllers\API\Lawyer\ContactYmtaz\LawyerContactYmtazController;
use App\Http\Controllers\API\Lawyer\Reservations\LawyerReservationsController;
use App\Http\Controllers\API\Lawyer\Services\LawyerServicesRequestsController;
use App\Http\Controllers\API\Client\DigitalGuide\ClientAPIDigitalGuideController;
use App\Http\Controllers\API\Lawyer\GeneralData\GeneralDataLawyerRegisterController;
use App\Http\Controllers\API\Lawyer\AdvisoryServices\LawyerAdvisoryServicesController;
use App\Http\Controllers\API\Lawyer\DigitalGuidePackages\DigitalGuidePackagesController;
use App\Http\Controllers\API\Client\AdvisoryCommittees\ClientAdvisoryCommitteesController;
use App\Http\Controllers\API\Lawyer\AdvisoryCommittees\LawyerAdvisoryCommitteesController;
use App\Http\Controllers\API\Lawyer\ServicesReservations\LawyerServicesLawyerReservationsController;
use App\Http\Controllers\API\Lawyer\Reservations\YmtazReservations\LawyerYmtazReservationsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [LawyerAuthController::class, 'register']);
Route::post('verification/first-step', [LawyerAuthController::class, 'verificationFirstStep']);
Route::post('check/verification/first-step', [LawyerAuthController::class, 'CheckVerificationFirstStep']);
Route::post('login', [LawyerAuthController::class, 'login']);
Route::post('newLogin', [LawyerAuthController::class, 'newLogin']);
Route::post('pos-forgot', [LawyerAuthController::class, 'postForgotPassword']);
Route::post('verification', [LawyerAuthController::class, 'forgotPasswordVerification']);
Route::post('reset', [LawyerAuthController::class, 'resetPassword']);

Route::get('check', [LawyerAuthController::class, 'Check']);

Route::middleware(['auth:api_lawyer', 'update.last.seen'])->group(function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [LawyerAuthController::class, 'getUserData']);
        Route::post('update', [LawyerAuthController::class, 'UpdateProfile']);
        Route::get('/clients', [ClientLawyersController::class, 'getProfileClients']);
        Route::post('/delete-account-request', [LawyerAuthController::class, 'DeleteAccountRequest']);
        Route::get('/analytics', [LawyerAuthController::class, 'analytics']);
    });
    Route::get('logout', [LawyerAuthController::class, 'logout']);
    Route::group(['prefix' => 'contact-ymtaz'], function () {
        Route::get('/', [LawyerContactYmtazController::class, 'list']);
        Route::post('/', [LawyerContactYmtazController::class, 'Store']);
    });
    Route::group(['prefix' => 'advisory-services'], function () {
        Route::post('/', [LawyerAdvisoryServicesController::class, 'CreateAdvisoryServices']);
        Route::post('/appointment', [LawyerAdvisoryServicesController::class, 'AppointmentAdvisoryServices']);
        Route::get('/ymtaz', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesRequests']);
        Route::get('/digital-guide', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesRequestsFromLawyers']);
        Route::post('/delay', [LawyerAdvisoryServicesController::class, 'DelayLawyerAdvisoryServicesRequests']);
        Route::post('/cancel', [LawyerAdvisoryServicesController::class, 'CancelLawyerAdvisoryServicesRequests']);
        Route::post('/rate', [LawyerAdvisoryServicesController::class, 'RateAdvisoryServicesReservation']);
        Route::post('/createPrice', [LawyerAdvisoryServicesController::class, 'CreateLawyerAdvisoryServicePrices']);
        Route::get('/availableForPricing', [LawyerAdvisoryServicesController::class, 'GetAvailableServicesForPricing']);
        Route::get('/requested/client', [LawyerAdvisoryServicesController::class, 'ListClientAdvisoryServicesReservations']);
        Route::get('/requested/lawyer', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesReservations']);
        Route::get('/requested/:id', [LawyerAdvisoryServicesController::class, 'listRequestedById']);
        Route::post('/requested/reply/client', [LawyerAdvisoryServicesController::class, 'ReplyAdvisoryServiceClient']);
        Route::post('/requested/reply/lawyer', [LawyerAdvisoryServicesController::class, 'ReplyAdvisoryServiceLawyer']);
        Route::delete('/{id}', [LawyerAdvisoryServicesController::class, 'deleteAdivsoryServicePrice']);
        Route::post('/{id}', [LawyerAdvisoryServicesController::class, 'changeAdvisoryServicePriceTask']);

    });
    // Route::group(['prefix' => 'reservations'], function () {
    //     Route::group(['prefix' => 'ymtaz'], function () {
    //         Route::get('/', [LawyerYmtazReservationsController::class, 'list']);
    //         Route::post('/create', [LawyerYmtazReservationsController::class, 'create']);
    //         Route::get('/{id}', [LawyerYmtazReservationsController::class, 'view']);
    //         Route::post('/update', [LawyerYmtazReservationsController::class, 'update']);
    //         Route::get('/cancel/{id}', [LawyerYmtazReservationsController::class, 'cancel']);
    //         Route::post('/rate', [LawyerYmtazReservationsController::class, 'rate']);
    //     });
    //     Route::get('/', [LawyerReservationsController::class, 'list']);
    //     Route::post('/create', [LawyerReservationsController::class, 'create']);
    //     Route::post('/update', [LawyerReservationsController::class, 'update']);
    //     Route::get('/cancel/{id}', [LawyerReservationsController::class, 'cancel']);

    //     Route::get('/requested', [LawyerReservationsController::class, 'listRequestedFromLawyerReservations']);

    // });
    Route::group(['prefix' => "payouts"], function () {
        Route::get("/", [LawyerPayoutsController::class, 'index']);
        Route::post("/", [LawyerPayoutsController::class, 'store']);
        Route::get("/wallet", [LawyerPayoutsController::class, 'wallet']);
    });
    Route::group(['prefix' => 'working-hours'], function () {
        Route::get('/', [WorkingHoursController::class, 'getWorkingHours']);
        Route::post('/', [WorkingHoursController::class, 'addWorkingHours']);
    });
    Route::group(["prefix" => "reservations"], function () {
        Route::get('/clients', [LawyerReservationsController::class, 'getMyReservationsClient']);
        Route::get('/lawyers', [LawyerReservationsController::class, 'getMyReservationsLawyer']);
        Route::get('/reserved/:id', [LawyerReservationsController::class, 'getMyReservationById']);
        Route::get('/importance', [LawyerReservationsController::class, 'getReservationImportance']);
        Route::get('/types', [LawyerReservationsController::class, 'getReservationTypes']);
        Route::get('/typeImportance', [LawyerReservationsController::class, 'getReservationTypeImportance']);
        Route::post('/', [LawyerReservationsController::class, 'createReservation']);
        Route::post('/pricing', [LawyerReservationsController::class, 'createReservationPrice']);
        Route::post('/end', [LawyerReservationsController::class, 'endReservation']);
        Route::delete('/{id}', [LawyerReservationsController::class, 'deleteReservationTypePrice']);
        Route::post('/{id}', [LawyerReservationsController::class, 'changeReservationTypePriceStatus']);
    });
    Route::group(['prefix' => 'services-request'], function () {
        Route::post('/', [LawyerServicesRequestsController::class, 'create']);
        Route::post('/create', [LawyerServicesRequestsController::class, 'CreateLawyerServicePrices']);
        Route::get('/getLawyerServicePrices', [LawyerServicesRequestsController::class, 'getServices']);
        Route::get('/', [LawyerServicesRequestsController::class, 'list']);
        Route::post('/rate', [LawyerServicesRequestsController::class, 'rate']);
        Route::get('/requested/client', [LawyerServicesRequestsController::class, 'listRequestedFromLawyerServicesRequests']);
        Route::get('/requested/lawyer', [LawyerServicesRequestsController::class, 'listLawyerRequestedFromLawyerServicesRequests']);
        Route::get('/requested/:id', [LawyerServicesRequestsController::class, 'listRequestedById']);
        Route::post('/requested/lawyer/reply', [LawyerServicesRequestsController::class, 'replyLawyer']);
        Route::post('/requested/client/reply', [LawyerServicesRequestsController::class, 'replyClient']);
        Route::delete('/{id}', [LawyerServicesRequestsController::class, 'deleteServicePrice']);
        Route::post('/{id}', [LawyerServicesRequestsController::class, 'changeServicePriceTask']);

    });
    Route::group(['prefix' => 'lawyer'], function () {
        Route::get('services/{id}', [LawyerServicesLawyerReservationsController::class, 'getServices']);
        Route::group(['prefix' => 'favorite'], function () {
            Route::get('/list', [LawyerAuthController::class, 'ListFavoritesLawyers']);
            Route::post('/add', [LawyerAuthController::class, 'AddFavoritesLawyers']);
        });
        Route::group(['prefix' => 'advisory-services'], function () {
            Route::post('/', [LawyerAuthController::class, 'CreateAdvisoryServicesReservations']);
        });
        Route::group(['prefix' => 'reservations'], function () {
            Route::post('/', [LawyerServicesLawyerReservationsController::class, 'CreateServicesReservations']);
            Route::get('/list', [LawyerServicesLawyerReservationsController::class, 'GetServicesReservations']);
            Route::get('/cancel', [LawyerServicesLawyerReservationsController::class, 'CancelServicesReservations']);
        });
        Route::get('/{id}', [ClientLawyersController::class, 'getProfile']);
    });
    Route::group(['prefix' => 'digital-guide'], function () {
        Route::get('/packages', [DigitalGuidePackagesController::class, 'GetDigitalGuidePackages']);
        Route::post('/subscribe', [DigitalGuidePackagesController::class, 'SubscribeToDigitalGuidePackage']);
        Route::post('/', [DigitalGuidePackagesController::class, 'SubscribeToDigitalGuidePackage']);
        Route::get('/complete/payment/{id}', [DigitalGuidePackagesController::class, 'CompletePaymentPackage']);
        Route::get('/cancel/payment/{id}', [DigitalGuidePackagesController::class, 'CancelPaymentPackage']);
        Route::get('/declined/payment/{id}', [DigitalGuidePackagesController::class, 'DeclinedPaymentPackage']);

    });

    Route::group(['prefix' => 'advisory-committees'], function () {
        Route::group(['prefix' => 'reservations'], function () {
            Route::get('/', [LawyerAdvisoryCommitteesController::class, 'listReservations']);
        });
    });
});
Route::middleware(['update.last.seen'])->prefix('general_data')->group(function () {
    Route::get('/general-specialty', [GeneralDataLawyerRegisterController::class, 'getGeneralSpecialty']);
    Route::get('/accurate-specialty', [GeneralDataLawyerRegisterController::class, 'getAccurateSpecialty']);
    Route::get('/functional-cases', [GeneralDataLawyerRegisterController::class, 'getFunctionalCases']);
    Route::get('/sections', [GeneralDataLawyerRegisterController::class, 'getSections']);
    Route::get('/degrees', [GeneralDataLawyerRegisterController::class, 'getDegrees']);
    Route::get('/countries', [GeneralDataLawyerRegisterController::class, 'getCountries']);
    Route::get('/nationalities', [GeneralDataLawyerRegisterController::class, 'getNationalities']);
    Route::get('/regions', [GeneralDataLawyerRegisterController::class, 'getRegions']);
    Route::get('/cities', [GeneralDataLawyerRegisterController::class, 'getCities']);
    Route::get('/districts', [GeneralDataLawyerRegisterController::class, 'getDistricts']);
    Route::get('/lawyer-types', [GeneralDataLawyerRegisterController::class, 'getLawyerTypes']);
    Route::get('/languages', [GeneralDataLawyerRegisterController::class, 'getLanguages']);
});


Route::middleware(['update.last.seen'])->prefix('advisory-services')->group(function () {
    Route::get('complete/payment/{id}', [LawyerAdvisoryServicesController::class, 'CompletePaymentClientAdvisoryServicesRequests'])->name('completePaymentLawyer');
    Route::get('cancel/payment/{id}', [LawyerAdvisoryServicesController::class, 'CancelPaymentClientAdvisoryServicesRequests'])->name('cancelPaymentLawyer');
    Route::get('declined/payment/{id}', [LawyerAdvisoryServicesController::class, 'DeclinedPaymentClientAdvisoryServicesRequests'])->name('declinedPaymentLawyer');
});
Route::middleware(['update.last.seen'])->prefix('reservations')->group(function () {
    Route::group(['prefix' => 'ymtaz'], function () {
        Route::get('/complete/payment/{id}', [LawyerYmtazReservationsController::class, 'CompletePaymentClientServicesRequests']);
        Route::get('/cancel/payment/{id}', [LawyerYmtazReservationsController::class, 'CancelPaymentClientServicesRequests']);
        Route::get('/declined/payment/{id}', [LawyerYmtazReservationsController::class, 'DeclinedPaymentClientServicesRequests']);
    });
});
Route::middleware(['update.last.seen'])->prefix('services-request')->group(function () {
    Route::get('/complete/payment/{id}', [LawyerServicesRequestsController::class, 'CompletePaymentLawyerServicesRequests']);
    Route::get('/cancel/payment/{id}', [LawyerServicesRequestsController::class, 'CancelPaymentLawyerServicesRequests']);
    Route::get('/declined/payment/{id}', [LawyerServicesRequestsController::class, 'DeclinedPaymentLawyerServicesRequests']);
});
Route::middleware(['update.last.seen'])->prefix('lawyer')->group(function () {
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/complete/payment/{id}', [LawyerServicesLawyerReservationsController::class, 'CompletePaymentClientServicesRequests']);
        Route::get('/cancel/payment/{id}', [LawyerServicesLawyerReservationsController::class, 'CancelPaymentClientServicesRequests']);
        Route::get('/declined/payment/{id}', [LawyerServicesLawyerReservationsController::class, 'DeclinedPaymentClientServicesRequests']);
    });


});
Route::middleware(['update.last.seen'])->prefix('services')->group(function () {
    Route::get('/list', [ServicesController::class, 'List']);
    Route::get('14/list', [ServicesController::class, 'List14']);
    Route::get('/main-category', [ServicesController::class, 'MainCategories']);
    Route::get('/sub-category', [ServicesController::class, 'SubCategories']);
    Route::get('/request-levels', [ServicesController::class, 'RequestLevels']);
});

//Device
Route::middleware(['update.last.seen'])->group(
    function () {
        Route::post('create-device', [LawyerDeviceController::class, 'CreateDevice'])->middleware('auth:api_lawyer');
        Route::post('delete-device/{device_id}', [LawyerDeviceController::class, 'DeleteDevice'])->middleware('auth:api_lawyer');
    }
);
Route::middleware(['update.last.seen'])->prefix('settings')->group(function () {
    Route::get('/terms-conditions', [LawyerSettingsController::class, 'LawyerTermsAndConditions']);
});
