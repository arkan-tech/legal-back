<?php

use App\Http\Controllers\API\Client\AdvisoryCommittees\ClientAdvisoryCommitteesController;
use App\Http\Controllers\API\Client\AdvisoryServices\ClientAdvisoryServicesController;
use App\Http\Controllers\API\Client\Auth\Register\ClientAuthController;
use App\Http\Controllers\API\Client\Books\ClientBooksController;
use App\Http\Controllers\API\Client\Contact\ClientContactYmtazController;
use App\Http\Controllers\API\Client\Device\ClientDeviceController;
use App\Http\Controllers\API\Client\DigitalGuide\ClientAPIDigitalGuideController;
use App\Http\Controllers\API\Client\Lawyer\ClientLawyersController;
use App\Http\Controllers\API\Client\Library\ClientLibraryController;
use App\Http\Controllers\API\Client\Profile\ClientProfileController;
use App\Http\Controllers\API\Client\Reservations\ClientReservationsController;
use App\Http\Controllers\API\Client\Reservations\YmtazReservations\ClientYmtazReservationsController;
use App\Http\Controllers\API\Client\Services\ClientServicesRequestsController;
use App\Http\Controllers\API\Client\Services\ServicesController;
use App\Http\Controllers\API\Client\ServicesReservations\ClientServicesLawyerReservationsController;
use App\Http\Controllers\API\Client\Settings\ClientSettingsController;
use App\Http\Controllers\API\Client\Settings\ClientYamtazSettingsController;
use App\Http\Controllers\API\Lawyer\GeneralData\GeneralDataLawyerRegisterController;
use App\Http\Controllers\API\payments\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('register', [ClientAuthController::class, 'register']);
Route::post('activate-account', [ClientAuthController::class, 'ActivateAccount']);
Route::post('login', [ClientAuthController::class, 'login']);
Route::post('newLogin', [ClientAuthController::class, 'newLogin']);
Route::post('pos-forgot', [ClientAuthController::class, 'postForgotPassword']);
Route::post('verification', [ClientAuthController::class, 'forgotPasswordVerification']);
Route::post('reset', [ClientAuthController::class, 'resetPassword']);
Route::post('confirmOtp', [ClientAuthController::class, 'confirmOtp']);
Route::get('check', [ClientAuthController::class, 'Check']);


Route::prefix('payments')
// ->middleware(['auth:api_client', 'update.last.seen'])
    ->group(function() {
        Route::post('/make-payment', [PaymentController::class, 'makePayment'])->name('makePayment');
        Route::get('/pay', [PaymentController::class, 'showPaymentForm'])->name('payment.showForm');

        Route::get('/hello', function () {
            return response()->json([
                'message' => 'Hello, World!'
            ]);
        });

    });

Route::middleware(['auth:api_client', 'update.last.seen'])->group(function () {
    Route::get('logout', [ClientAuthController::class, 'logout']);
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ClientProfileController::class, 'Profile']);
        Route::post('/', [ClientProfileController::class, 'Update']);
        Route::post('/update/profile-image', [ClientProfileController::class, 'UpdateProfileImage']);
        Route::post('/password', [ClientProfileController::class, 'UpdatePassword']);
        Route::post('/delete-account-request', [ClientProfileController::class, 'DeleteAccountRequest']);
    });
    Route::group(['prefix' => 'contact-ymtaz'], function () {
        Route::get('/', [ClientContactYmtazController::class, 'List']);
        Route::post('/', [ClientContactYmtazController::class, 'Store']);
    });
    Route::group(['prefix' => 'advisory-services'], function () {
        Route::post('/', [ClientAdvisoryServicesController::class, 'CreateAdvisoryServices']);
        Route::get('/ymtaz', [ClientAdvisoryServicesController::class, 'ListClientAdvisoryServicesRequests']);
        Route::get('/digital-guide', [ClientAdvisoryServicesController::class, 'ListClientAdvisoryServicesRequestsFromLawyers']);
        Route::post('/delay', [ClientAdvisoryServicesController::class, 'DelayClientAdvisoryServicesRequests']);
        Route::post('/cancel', [ClientAdvisoryServicesController::class, 'CancelClientAdvisoryServicesRequests']);
        Route::post('/appointment', [ClientAdvisoryServicesController::class, 'AppointmentAdvisoryServices']);
        Route::post('/rate', [ClientAdvisoryServicesController::class, 'RateAdvisoryServicesReservation']);
    });
    // Needs revamp as some of these have been revamped in merged section
    Route::group(['prefix' => 'reservations'], function () {
        Route::group(['prefix' => 'ymtaz'], function () {
            Route::get('/', [ClientYmtazReservationsController::class, 'list']);
            Route::get('/{id}', [ClientYmtazReservationsController::class, 'view']);
            Route::post('/create', [ClientYmtazReservationsController::class, 'create']);
            Route::post('/update', [ClientYmtazReservationsController::class, 'update']);
            Route::get('/cancel/{id}', [ClientYmtazReservationsController::class, 'cancel']);
            Route::post('/rate', [ClientYmtazReservationsController::class, 'rate']);
        });

        Route::get('/', [ClientReservationsController::class, 'list']);
        Route::post('/create', [ClientReservationsController::class, 'create']);
        Route::post('/update', [ClientReservationsController::class, 'update']);
        Route::get('/cancel/{id}', [ClientReservationsController::class, 'cancel']);
    });
    Route::group(['prefix' => 'services-request'], function () {
        Route::post('/', [ClientServicesRequestsController::class, 'create']);
        Route::post('/rate', [ClientServicesRequestsController::class, 'rate']);
        Route::get('/', [ClientServicesRequestsController::class, 'list']);
    });
    Route::group(['prefix' => 'lawyer'], function () {
        Route::get('/{id}', [ClientLawyersController::class, 'getProfile']);
        Route::get('services/{id}', [ClientServicesLawyerReservationsController::class, 'getServices']);
        Route::group(['prefix' => 'favorite'], function () {
            Route::get('/list', [ClientLawyersController::class, 'ListFavoritesLawyers']);
            Route::post('/add', [ClientLawyersController::class, 'AddFavoritesLawyers']);
        });
        Route::group(['prefix' => 'advisory-services'], function () {
            Route::post('/', [ClientLawyersController::class, 'CreateAdvisoryServicesReservations']);
        });
        // Needs revamp as reservations are made in merged section
        Route::group(['prefix' => 'reservations'], function () {
            Route::post('/', [ClientServicesLawyerReservationsController::class, 'CreateServicesReservations']);
            Route::get('/list', [ClientServicesLawyerReservationsController::class, 'GetServicesReservations']);
            Route::get('/cancel', [ClientServicesLawyerReservationsController::class, 'CancelServicesReservations']);
        });
        // Needs revamp as some of these has been replaced
        Route::group(['prefix' => 'services-request'], function () {
            Route::get('/', [ClientLawyersController::class, 'ListServicesRequest']);
            Route::post('/', [ClientLawyersController::class, 'CreateServicesRequest']);
        });

        Route::group(['prefix' => 'rate'], function () {
            Route::post('add/', [ClientLawyersController::class, 'CreateLawyerRate']);
        });

    });
    Route::group(['prefix' => 'advisory-committees'], function () {
        Route::group(['prefix' => 'reservations'], function () {
            Route::get('/', [ClientAdvisoryCommitteesController::class, 'listReservations']);
        });
    });
    Route::group(['prefix' => 'books'], function () {
        Route::group(['prefix' => 'rate'], function () {
            Route::post('/add', [ClientBooksController::class, 'addRate']);
        });
        Route::group(['prefix' => 'fav'], function () {
            Route::get('/list', [ClientBooksController::class, 'listFav']);
            Route::post('/add', [ClientBooksController::class, 'addFav']);
        });
    });
});
// end Routes With Auth ///

// start Routes Without Auth ///
Route::middleware(['update.last.seen'])->prefix('advisory-services')->group(function () {
    Route::get('complete/payment/{id}', [ClientAdvisoryServicesController::class, 'CompletePaymentClientAdvisoryServicesRequests'])->name('completePayment');
    Route::get('cancel/payment/{id}', [ClientAdvisoryServicesController::class, 'CancelPaymentClientAdvisoryServicesRequests'])->name('cancelPayment');
    Route::get('declined/payment/{id}', [ClientAdvisoryServicesController::class, 'DeclinedPaymentClientAdvisoryServicesRequests'])->name('declinedPayment');
});
Route::middleware(['update.last.seen'])->prefix('services-request')->group(function () {
    Route::get('/complete/payment/{id}', [ClientServicesRequestsController::class, 'CompletePaymentClientServicesRequests']);
    Route::get('/cancel/payment/{id}', [ClientServicesRequestsController::class, 'CancelPaymentClientServicesRequests']);
    Route::get('/declined/payment/{id}', [ClientServicesRequestsController::class, 'DeclinedPaymentClientServicesRequests']);
});
Route::middleware(['update.last.seen'])->prefix('lawyer')->group(function () {
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('/complete/payment/{id}', [ClientServicesLawyerReservationsController::class, 'CompletePaymentClientServicesRequests']);
        Route::get('/cancel/payment/{id}', [ClientServicesLawyerReservationsController::class, 'CancelPaymentClientServicesRequests']);
        Route::get('/declined/payment/{id}', [ClientServicesLawyerReservationsController::class, 'DeclinedPaymentClientServicesRequests']);
    });
});
Route::middleware(['update.last.seen'])->prefix('reservations')->group(function () {
    Route::group(['prefix' => 'ymtaz'], function () {
        Route::get('/complete/payment/{id}', [ClientYmtazReservationsController::class, 'CompletePaymentClientServicesRequests']);
        Route::get('/cancel/payment/{id}', [ClientYmtazReservationsController::class, 'CancelPaymentClientServicesRequests']);
        Route::get('/declined/payment/{id}', [ClientYmtazReservationsController::class, 'DeclinedPaymentClientServicesRequests']);
    });
});
Route::middleware(['update.last.seen'])->prefix('advisory-services')->group(function () {
    Route::get('/services', [ClientAdvisoryServicesController::class, 'ListAdvisoryServices']);
    Route::get('/types', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesTypes']);
    Route::get('/types/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryTypesByAdvisoryServiceId']);
    Route::get('/base', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesBase']);
    Route::get('/base/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesPaymentCategoriesByBaseId']);
    Route::get('/payment-categories', [ClientAdvisoryServicesController::class, 'paymentMethods']);
    Route::get('/base-payment-category-id/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesBasePaymentMethod']);

});
Route::middleware(['update.last.seen'])->prefix('reservation-requirements')->group(function () {
    Route::get('/importance-type', [ClientReservationsController::class, 'ImportanceType']);
    Route::get('/reservation-types', [ClientReservationsController::class, 'ReservationType']);
});
Route::middleware(['update.last.seen'])->prefix('services')->group(function () {
    Route::get('/list', [ServicesController::class, 'List']);
    Route::get('14/list', [ServicesController::class, 'List14']);
    Route::get('/main-category', [ServicesController::class, 'MainCategories']);
    Route::get('/sub-category', [ServicesController::class, 'SubCategories']);
    Route::get('/request-levels', [ServicesController::class, 'RequestLevels']);
});

Route::middleware(['update.last.seen'])->prefix('settings')->group(function () {
    Route::get('/available-dates', [ClientYamtazSettingsController::class, 'getYmtazDates']);
    Route::get('/terms-conditions', [ClientSettingsController::class, 'gettermsAndConditions']);
});


Route::middleware(['update.last.seen'])->prefix('lawyer')->group(function () {
    Route::get('/{id}/advisory-services', [ClientLawyersController::class, 'getAdvisoryServices']);
});

Route::middleware(['update.last.seen'])->prefix('books')->group(function () {
    Route::get('/', [ClientBooksController::class, 'index']);
});

// end Routes Without Auth ///

//Device
Route::middleware(['update.last.seen'])->group(function () {
    Route::post('create-device', [ClientDeviceController::class, 'CreateDevice'])->middleware('auth:api_client');
    Route::post('delete-device/{device_id}', [ClientDeviceController::class, 'DeleteDevice'])->middleware('auth:api_client');
});