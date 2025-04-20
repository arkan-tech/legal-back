<?php

use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\API\ContentController;
use App\Http\Controllers\API\SectionController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\API\Merged\AuthController;
use App\Http\Controllers\GoogleAnalyticsController;
use App\Http\Controllers\API\Merged\BooksController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\API\Merged\MailerController;
use App\Http\Controllers\API\Splash\SplashController;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Controllers\API\Merged\BannersController;
use App\Http\Controllers\API\Merged\LawGuideController;
use App\Http\Controllers\API\Merged\PackagesController;
use App\Http\Controllers\API\Admin\AdminCheckController;
use App\Http\Controllers\API\Merged\BookGuideController;
use App\Http\Controllers\API\Merged\AccountFCMController;
use App\Http\Controllers\API\Merged\ActivitiesController;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Controllers\API\Merged\EliteProductController;
use App\Http\Controllers\API\Lawyer\LawyerPayoutsController;
use App\Http\Controllers\API\Merged\Lawyer\LawyerController;
use App\Http\Controllers\API\Merged\AccountInvitesController;
use App\Http\Resources\API\Lawyer\LawyerNewShortDataResource;
use App\Http\Tasks\Merged\Reservations\GetVisitorProfileTask;
use App\Http\Controllers\API\Lawyer\AccountBankInfoController;
use App\Http\Controllers\API\Merged\Profile\ProfileController;
use App\Http\Controllers\API\Client\Services\ServicesController;
use App\Http\Controllers\API\Merged\Payments\PaymentsController;
use App\Http\Controllers\API\Lawyer\AccountExperiencesController;
use App\Http\Controllers\API\Client\Lawyer\ClientLawyersController;
use App\Http\Controllers\API\Merged\FastSearch\FastSearchController;
use App\Http\Controllers\API\Merged\ContactUs\ContactYmtazController;
use App\Http\Controllers\API\Visitor\Profile\VisitorProfileController;
use App\Http\Controllers\API\Lawyer\WorkingHours\WorkingHoursController;
use App\Http\Controllers\API\Merged\Reservations\ReservationsController;
use App\Http\Controllers\API\Merged\Notifications\NotificationController;
use App\Http\Controllers\API\Merged\ClientServicesRequestsOfferController;
use App\Http\Controllers\API\Merged\JudicialGuide\JudicialGuideController;
use App\Http\Controllers\API\Merged\LawyerServicesRequestsOffersController;
use App\Http\Controllers\API\Client\Services\ClientServicesRequestsController;
use App\Http\Controllers\API\Lawyer\Reservations\LawyerReservationsController;
use App\Http\Controllers\API\Lawyer\Services\LawyerServicesRequestsController;
use App\Http\Controllers\API\Merged\FavouriteLawyers\FavouriteLawyersController;
use App\Http\Controllers\API\Merged\PaymentsController as PaymentsControllerAPI;
use App\Http\Controllers\API\Client\DigitalGuide\ClientAPIDigitalGuideController;
use App\Http\Controllers\API\Lawyer\GeneralData\GeneralDataLawyerRegisterController;
use App\Http\Controllers\API\Merged\FavouriteLawGuides\FavouriteLawGuidesController;
use App\Http\Controllers\API\Client\AdvisoryServices\ClientAdvisoryServicesController;
use App\Http\Controllers\API\Lawyer\AdvisoryServices\LawyerAdvisoryServicesController;
use App\Http\Controllers\API\Merged\FavouriteBookGuides\FavouriteBookGuidesController;
use App\Http\Controllers\API\Client\AdvisoryCommittees\ClientAdvisoryCommitteesController;
use App\Http\Controllers\API\Merged\FavouriteLearningPathItems\FavouriteLearningPathItemsController;
use App\Http\Controllers\API\Merged\WorkingHours\WorkingHoursController as WorkingHoursControllerMerged;

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

Route::get('splash', [SplashController::class, 'getSplashList']);
Route::get('benefit', [SplashController::class, 'getBenefitList']);

Route::middleware(['update.last.seen'])->prefix('v1')->group(function () {
    Route::get('recentlyJoinedLawyers', [LawyerController::class, 'getNewAdvisories']);
});
Route::group(["prefix" => "payments"], function () {
    Route::get("/callback", [PaymentsController::class, "callback"])->name('callback');
});

Route::get('version', [SplashController::class, 'getVersion']);

Route::group(["prefix" => 'v1/auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/check-phone', [AuthController::class, 'checkPhone']);
    Route::post('/confirm-phone', [AuthController::class, 'confirmPhone']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/check', [AuthController::class, 'check']);
    Route::post('/forget-password', [AuthController::class, 'createForgetPassword']);
    Route::post('/check-password', [AuthController::class, 'checkForgetPassword']);
    Route::post('/reset-password', [AuthController::class, 'changePassword']);
});

Route::group(['middleware' => ['web'], 'prefix' => 'auth'], function () {
    Route::get('/google', [LoginController::class, 'redirectToGoogle']);
    Route::get('/google/callback/{token}', [LoginController::class, 'handleGoogleCallback']);
    Route::get('/apple', [LoginController::class, 'redirectToApple']);
    Route::get('/apple/callback/{token}', [LoginController::class, 'handleAppleCallback']);
});
Route::group(['middleware' => 'auth:api_visitor', 'prefix' => "visitor"], function () {
    Route::get('profile', [VisitorProfileController::class, 'getProfile']);
    Route::get('/devices/create', [VisitorProfileController::class, 'getProfile']);
    Route::delete('/devices/delete', [VisitorProfileController::class, 'getProfile']);
});
Route::middleware(['check.user.type:client,lawyer', 'update.last.seen'])->prefix("v1")->group(function () {
    Route::group(["prefix" => "packages"], function () {
        Route::get("/", [PackagesController::class, 'getPackages']);
        Route::post("/subscribe", [PackagesController::class, "subscribe"]);
    });
    Route::group(["prefix" => "lawyer"], function () {
        Route::get('{id}/reservations', [ReservationsController::class, 'getLawyerReservations']);
        Route::post('{id}/favourite', [FavouriteLawyersController::class, "createFavourite"]);
        Route::get('{id}/services', [LawyerController::class, 'getLawyerServices']);
        Route::get('/{id}/advisory-services', [ClientLawyersController::class, 'getAdvisoryServices']);
        Route::get('{id}', [ClientLawyersController::class, 'getProfile']);
    });
    Route::group(["prefix" => "invites"], function () {
        Route::get('/', [AccountInvitesController::class, 'getInvites']);
        Route::post('/', [AccountInvitesController::class, 'createInvite']);
    });
    Route::prefix('services')->group(function () {
        Route::get('/request-levels', [ServicesController::class, 'RequestLevels']);
        Route::get('/requests', [ClientServicesRequestsController::class, 'list']);
        // Route::post('/requests', [ClientServicesRequestsController::class, 'create']);
        Route::post('/requests', [ClientServicesRequestsOfferController::class, 'createViaTask']);
        Route::get('/{service_id}/lawyers', [ClientServicesRequestsController::class, 'getLawyersByServiceId']);
        Route::get('/requests/offers', [ClientServicesRequestsOfferController::class, 'getOffers']);
        Route::post('/requests/respond', [ClientServicesRequestsOfferController::class, 'respondToOffers']);
        Route::get('/requests/{id}', [ClientServicesRequestsController::class, 'getReservationById']);
    });
    Route::group(['prefix' => 'advisory-services'], function () {
        Route::post('/', [ClientAdvisoryServicesController::class, 'CreateAdvisoryServices']);
        Route::get('/ymtaz', [ClientAdvisoryServicesController::class, 'ListClientAdvisoryServicesRequests']);
        Route::get('/digital-guide', [ClientAdvisoryServicesController::class, 'ListClientAdvisoryServicesRequestsFromLawyers']);
        // Route::get('/services', [ClientAdvisoryServicesController::class, 'ListAdvisoryServices']);
        // Route::get('/types', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesTypes']);
        // Route::get('/types/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryTypesByAdvisoryServiceId']);
        // Route::get('/base', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesBase']);
        // Route::get('/base/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesPaymentCategoriesByBaseId']);
        // Route::get('/payment-categories', [ClientAdvisoryServicesController::class, 'paymentMethods']);
        Route::get('/payment-categories-types/{id}/general/{g_id}/sub/{s_id}/lawyers', [ClientAdvisoryServicesController::class, 'getLawyersByAdvisoryServiceGeneralSubId']);
        // Route::get('/base-payment-category-id/{id}', [ClientAdvisoryServicesController::class, 'ListAdvisoryServicesBasePaymentMethod']);
        Route::get('sub/{sub_id}/lawyers', [ClientAdvisoryServicesController::class, 'getLawyersByAdvisoryServiceTypeId']);
        Route::get('requests/{id}', [ClientAdvisoryServicesController::class, 'getReservationById']);
    });
    Route::group(['prefix' => "payouts"], function () {
        Route::get("/", [LawyerPayoutsController::class, 'index']);
        Route::post("/", [LawyerPayoutsController::class, 'store']);
        Route::get("/wallet", [LawyerPayoutsController::class, 'wallet']);
    });
    Route::prefix('device')->group(function () {
        Route::post('/', [AccountFCMController::class, 'createDevice']);
        Route::delete('/{device_id}', [AccountFCMController::class, 'deleteDevice']);
    });
    Route::group(['prefix' => 'activities'], function () {
        Route::get('/', [ActivitiesController::class, 'getActivities']);
    });
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', [ProfileController::class, 'getProfile']);
        Route::post('/', [ProfileController::class, 'updateProfile']);
        Route::get('/my-page', [ProfileController::class, 'getMypage']);
        Route::get('/analytics', [ProfileController::class, 'getAnalytics']);
        Route::get('/favourites', [FavouriteLawyersController::class, 'getFavouriteLawyers']);
        Route::get('/lawyers', [ClientLawyersController::class, 'getProfileLawyers']);
        Route::get('/clients', [ClientLawyersController::class, 'getProfileClients']);
        Route::get('/package', [PackagesController::class, 'getSubscriptionDetails']);

    });
    Route::group(['prefix' => 'payments'], function () {
        Route::get('/', [PaymentsControllerAPI::class, 'getPayments']);
    });
    Route::group(['prefix' => "auth"], function () {
        Route::post('/confirm-otp', [AuthController::class, 'confirmOtp']);
        Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    });
    Route::group(['prefix' => "fast-search"], function () {
        Route::get('/', [FastSearchController::class, 'fastSearch']);
    });

    Route::group(["prefix" => "reservations"], function () {
        Route::get('/offers', [ReservationsController::class, 'getReservationRequests']);
        Route::get('/booked', [ReservationsController::class, 'getMyReservations']);
        Route::get('types/{rti_id}/lawyers', [ReservationsController::class, 'getLawyersByReservationTypeId']);
        Route::post('create', [ReservationsController::class, 'createReservationRequest']);
        Route::post('/replyToOffer', [ReservationsController::class, 'replyToOffer']);
        // Route::get('types/{id}', [ReservationsController::class, 'getReservationTypesForLawyer']);
        // Route::get('booked/digital-guide', [ReservationsController::class, 'getMyReservationsFromDigitalGuide']);

        // Create a reservation from available reservations (client, lawyer)
        // Route::get('/{reservation_type_id}/lawyers', [ReservationsController::class, 'getLawyersByReservationTypeId']);
        // Route::get('/main-category', [ReservationsController::class, 'MainCategories']);
        // // Route::get('/sub-category', [ReservationsController::class, 'SubCategories']);
        // Route::post('/request', [ReservationsController::class, 'createRequest'])->middleware('validate.create.request');
        // Route::post('/request/reply', [ReservationsController::class, 'replyWithOffer']);
        // Route::post('/request/confirm', [ReservationsController::class, 'confirmOffer']);
        // Route::get('/my-requests', [ReservationsController::class, 'getMyRequestedRequests']);
        // Route::get('/my-reservations', [ReservationsController::class, 'getMyRequestedReservations']);
        // Route::get('/lawyer-requests', [ReservationsController::class, 'getRequestedReservationsFromMe']);
        // Route::post('/confirm-ending', [ReservationsController::class, 'confirmReservationEnding']);
    });
    Route::group(['prefix' => 'contact-us'], function () {
        Route::get('/', [ContactYmtazController::class, "getRequests"]);
        Route::get('/types', [ContactYmtazController::class, "getTypes"]);
        Route::get('/{id}', [ContactYmtazController::class, "getRequestById"]);
    });

    Route::get('/most-bought', [ProfileController::class, 'getMostBought']);


    Route::group(['prefix' => 'working-hours'], function () {
        Route::get("/{id}", [WorkingHoursControllerMerged::class, "fetchAvailableHours"]);
    });
    Route::group(['prefix' => 'law-guide'], function () {
        Route::get('/sub/{subId}', [LawGuideController::class, 'getSubLawGuide']);
        Route::post('laws/{id}/favourite', [FavouriteLawGuidesController::class, 'createFavourite']);
        Route::get('favourites', [FavouriteLawGuidesController::class, 'getFavouriteLawGuides']);
    });
    Route::group(["prefix" => "notifications"], function () {
        Route::get("/", [NotificationController::class, "getNotifications"]);
        Route::post("/seen", [NotificationController::class, "markAsSeen"]);

    });
    Route::group(['prefix' => 'elite'], function () {
        Route::get('categories', [EliteProductController::class, 'getCategories']);
        Route::get('requests', [EliteProductController::class, 'getRequests']);
        Route::post('requests', [EliteProductController::class, 'createRequest']);
        Route::post('offers/{offerId}/counter', [EliteProductController::class, 'counterOffer']);
        Route::post('offers/{offerId}/approve', [EliteProductController::class, 'approveOffer']);
    });
    Route::prefix('learning-paths')->group(function () {
        Route::get('/', [\App\Http\Controllers\API\LearningPathController::class, 'getAllPaths']);
        Route::get('/{id}/learning-path-items', [\App\Http\Controllers\API\LearningPathController::class, 'getLearningPathItems']);
        Route::post('/', [\App\Http\Controllers\API\LearningPathController::class, 'markAsRead']);
        Route::post('/learning-path-items/{id}/favourite', [FavouriteLearningPathItemsController::class, 'createFavourite']);
        Route::get('/learning-path-items/{id}/favourites', [FavouriteLearningPathItemsController::class, 'getFavouriteLearningPathItems']);
    });
});
// Route::middleware(['check.user.type:client,lawyer', 'update.last.seen'])->prefix('v1')->group(function () {

// });
Route::middleware(['check.user.type:lawyer', 'update.last.seen'])->prefix('v1')->group(function () {
    Route::group(['prefix' => 'advisory-services'], function () {
        // Route::post('/', [LawyerAdvisoryServicesController::class, 'CreateAdvisoryServices']);
        // Route::post('/appointment', [LawyerAdvisoryServicesController::class, 'AppointmentAdvisoryServices']);
        // Route::get('/ymtaz', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesRequests']);
        // Route::get('/digital-guide', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesRequestsFromLawyers']);
        // Route::post('/delay', [LawyerAdvisoryServicesController::class, 'DelayLawyerAdvisoryServicesRequests']);
        // Route::post('/cancel', [LawyerAdvisoryServicesController::class, 'CancelLawyerAdvisoryServicesRequests']);
        // Route::post('/rate', [LawyerAdvisoryServicesController::class, 'RateAdvisoryServicesReservation']);
        // Route::get('/requested/client', [LawyerAdvisoryServicesController::class, 'ListClientAdvisoryServicesReservations']);
        // Route::get('/requested/lawyer', [LawyerAdvisoryServicesController::class, 'ListLawyerAdvisoryServicesReservations']);
        // Route::get('/requested/:id', [LawyerAdvisoryServicesController::class, 'listRequestedById']);
        // Route::post('/requested/reply/client', [LawyerAdvisoryServicesController::class, 'ReplyAdvisoryServiceClient']);
        // Route::post('/requested/reply/lawyer', [LawyerAdvisoryServicesController::class, 'ReplyAdvisoryServiceLawyer']);
        Route::post('/createPrice', [LawyerAdvisoryServicesController::class, 'CreateLawyerAdvisoryServicePrices']);
        Route::get('/availableForPricing', [LawyerAdvisoryServicesController::class, 'GetAvailableServicesForPricing']);
        Route::delete('/{id}', [LawyerAdvisoryServicesController::class, 'deleteAdivsoryServicePrice']);
        Route::post('/{id}', [LawyerAdvisoryServicesController::class, 'changeAdvisoryServicePriceTask']);
        Route::get('/requested', [LawyerAdvisoryServicesController::class, 'ListClientAdvisoryServicesReservations']);
        Route::post('/requested/reply', [LawyerAdvisoryServicesController::class, 'ReplyAdvisoryServiceClient']);

    });
    Route::group(['prefix' => 'services-request'], function () {
        // Route::post('/', [LawyerServicesRequestsController::class, 'create']);
        // Route::get('/', [LawyerServicesRequestsController::class, 'list']);
        // Route::post('/rate', [LawyerServicesRequestsController::class, 'rate']);
        // Route::get('/requested/client', [LawyerServicesRequestsController::class, 'listRequestedFromLawyerServicesRequests']);
        // Route::get('/requested/lawyer', [LawyerServicesRequestsController::class, 'listLawyerRequestedFromLawyerServicesRequests']);
        // Route::get('/requested/:id', [LawyerServicesRequestsController::class, 'listRequestedById']);
        // Route::post('/requested/lawyer/reply', [LawyerServicesRequestsController::class, 'replyLawyer']);
        // Route::post('/requested/client/reply', [LawyerServicesRequestsController::class, 'replyClient']);
        Route::get('/getLawyerServicePrices', [LawyerServicesRequestsController::class, 'getServices']);
        Route::post('/create', [LawyerServicesRequestsController::class, 'CreateLawyerServicePrices']);
        Route::get('/requested', [LawyerServicesRequestsController::class, 'listRequestedFromLawyerServicesRequests']);
        Route::get('/pending', [LawyerServicesRequestsOffersController::class, 'getPendingRequests']);
        Route::post('/pending/offer', [LawyerServicesRequestsOffersController::class, 'addOffer']);
        // Route::post('/requested/{id}', [LawyerServicesRequestsController::class, 'getRequestById']);
        Route::post('/requested/reply', [LawyerServicesRequestsController::class, 'replya']);
        Route::delete('/{id}', [LawyerServicesRequestsController::class, 'deleteServicePrice']);
        Route::post('/{id}', [LawyerServicesRequestsController::class, 'changeServicePriceTask']);
    });
    Route::group(['prefix' => 'working-hours'], function () {
        Route::get('/', [WorkingHoursController::class, 'getWorkingHours']);
        Route::post('/', [WorkingHoursController::class, 'addWorkingHours']);
    });
    Route::group(["prefix" => "reservations"], function () {
        // Route::get('/clients', [LawyerReservationsController::class, 'getMyReservationsClient']);
        // Route::get('/lawyers', [LawyerReservationsController::class, 'getMyReservationsLawyer']);
        // Route::get('/reserved/:id', [LawyerReservationsController::class, 'getMyReservationById']);
        // Route::get('/importance', [LawyerReservationsController::class, 'getReservationImportance']);
        // Route::get('/typeImportance', [LawyerReservationsController::class, 'getReservationTypeImportance']);
        // Route::post('/', [LawyerReservationsController::class, 'createReservation']);
        // Route::post('/end', [LawyerReservationsController::class, 'endReservation']);
        Route::get('/pricing', [ReservationsController::class, 'getReservationTypesForPricing']);
        Route::post('/pricing', [LawyerReservationsController::class, 'createReservationPrice']);
        // Route::get('/types', [LawyerReservationsController::class, 'getReservationTypes']);
        Route::get('/lawyer-offers', [ReservationsController::class, 'lawyerGetReservationRequests']);
        Route::post('/replyWithOffer', [ReservationsController::class, 'replyWithOffer']);
        Route::get('/requested', [LawyerReservationsController::class, 'getMyReservationsClient']);
        Route::post('/requested/{reservation_id}/start', [ReservationsController::class, 'confirmReservationStart']);
        Route::delete('/{id}', [LawyerReservationsController::class, 'deleteReservationTypePrice']);
        Route::post('/{id}', [LawyerReservationsController::class, 'changeReservationTypePriceStatus']);

    });
    Route::group(['prefix' => 'account'], function () {
        Route::get('bank-info', [AccountBankInfoController::class, 'show']);
        Route::post('bank-info', [AccountBankInfoController::class, 'update']);
        Route::get('experiences', [AccountExperiencesController::class, 'index']);
        Route::post('experiences', [AccountExperiencesController::class, 'store']);
    });
    Route::group(['prefix' => 'elite'], function () {
        Route::get('pricing-requests', [EliteProductController::class, 'getPendingPricing']);
        Route::post('pricing-requests/reply', [EliteProductController::class, 'addPricing']);
    });

});
Route::middleware(['check.user.type:client,lawyer'])->prefix('v1')->group(function () {
    Route::get('admin/check', [AdminCheckController::class, 'checkIfAdmin']);
});
// Route::middleware(['auth:api_visitor', 'update.last.seen'])->prefix('v1')->group(function () {
//     Route::group(["prefix" => "notifications"], function () {
//         Route::get("/", [NotificationController::class, "getNotifications"]);
//         Route::post("/seen", [NotificationController::class, "markAsSeen"]);

//     });

// });
Route::middleware(['update.last.seen'])->prefix('v1')->group(function () {
    Route::prefix('judicial-guide')->controller(JudicialGuideController::class)->group(function () {
        Route::get('main', 'getMain');
        Route::get('main/{id}', 'getSub');
        Route::get('main/sub/{id}', 'getJudicialGuides');
        Route::get('{id}', 'getJudicialGuideById');
    });
    Route::group(['prefix' => 'contact-us'], function () {
        Route::post('/', [ContactYmtazController::class, "create"]);
    });
    Route::group(['prefix' => 'advisory-services'], function () {
        Route::get('/payment-categories-types', [ClientAdvisoryServicesController::class, 'paymentCategoriesTypes']);
        Route::get('/payment-categories-types/{id}/general', [ClientAdvisoryServicesController::class, 'getAdvisoryServicesGeneralCategories']);
        Route::get('/payment-categories-types/{id}/general/{g_id}/sub', [ClientAdvisoryServicesController::class, 'getAdvisoryServicesGeneralCategoriesSub']);
    });
    Route::group(['prefix' => 'services'], function () {
        Route::get('/main-category', [ServicesController::class, 'MainCategories']);
        Route::get('/sub-category', [ServicesController::class, 'SubCategories']);
    });
    Route::group(['prefix' => 'banners'], function () {
        Route::get('/', [BannersController::class, 'getBanners']);
    });
    Route::group(['prefix' => 'reservations'], function () {
        Route::get('types', action: [ReservationsController::class, 'getReservationTypes']);
    });
    Route::prefix('books')->controller(BooksController::class)->group(function () {
        Route::get('main', 'getMain');
        Route::get('main/{id}', 'getSub');
        Route::get('main/sub/{id}', 'getBooks');
        Route::get('{id}', 'getBookById');
    });
    Route::group(['prefix' => 'advisory-committees'], function () {
        Route::get('/categories', [ClientAdvisoryCommitteesController::class, 'getCategories']);
        Route::get('advisors/categories/{id}', [ClientAdvisoryCommitteesController::class, 'getAdvisorsBaseCategoryId']);
    });
    Route::group(['prefix' => 'digital-guide'], function () {
        Route::get('/categories', [ClientAPIDigitalGuideController::class, 'getCategories']);
        Route::post('/search', [ClientAPIDigitalGuideController::class, 'getLawyersBaseFilter']);
        Route::group(['prefix' => "filter/data"], function () {
            Route::get('/countries', [GeneralDataLawyerRegisterController::class, 'getCountries']);
            Route::get('/cities', [GeneralDataLawyerRegisterController::class, 'getCities']);
            Route::get('/districts', [GeneralDataLawyerRegisterController::class, 'getDistricts']);
        });
    });
    Route::group(['prefix' => 'law-guide'], function () {
        Route::get('main', [LawGuideController::class, 'getMain']);
        Route::get('main/{id}', [LawGuideController::class, 'getSubFromMain']);
        Route::get('law/{lawId}', [LawGuideController::class, 'getLawById']);
        Route::post('/search', [LawGuideController::class, 'search']);
        Route::get('{id}/related', [LawGuideController::class, 'getRelatedLawGuides']);
        Route::get('law/{lawId}/related', [LawGuideController::class, 'getRelatedLaws']);
    });
    Route::group(['prefix' => 'book-guide'], function () {
        Route::get('main', [BookGuideController::class, 'getMain']);
        Route::get('main/{id}', [BookGuideController::class, 'getSubFromMain']);
        Route::get('sections/{sectionId}', [BookGuideController::class, 'getBookById']);
        Route::post('/search', [BookGuideController::class, 'search']);
        Route::post('sections/{id}/favourite', [FavouriteBookGuidesController::class, 'createFavourite']);
        Route::get('favourites', [FavouriteBookGuidesController::class, 'getFavouriteBookGuides']);
    });

    Route::group(['prefix' => "auth"], function () {
        Route::post('/confirm-email', [AuthController::class, 'confirmEmail']);
        Route::post('/confirm-email-lawyer', [AuthController::class, 'confirmEmailLawyer']);
    });

    Route::prefix('general-data')->middleware('set_language')->group(function () {
        Route::get('/static-page/{key}', [StaticPagesController::class, 'show']);
        Route::get('/homepage', [StaticPagesController::class, 'getHomePage']);
    });

    Route::prefix('/mailer')->group(function () {
        Route::post('/subscribe', [MailerController::class, 'subscribe']);
        Route::post('/unsubscribe', [MailerController::class, 'unsubscribe']);
    });
});
Route::post('/send-notification', [PushNotificationController::class, 'sendPushNotification']);
Route::get('/analytics', [GoogleAnalyticsController::class, 'getAnalyticsData']);