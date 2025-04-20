<?php

use App\Http\Controllers\Site\Lawyer\AdministrativeOffice\AdministrativeOfficeController;
use App\Http\Controllers\Site\Lawyer\Auth\LawyerAuthController;
use App\Http\Controllers\Site\Lawyer\Auth\RegisterLawyerController;
use App\Http\Controllers\Site\Lawyer\ClientAdvisoryServicesReservations\ClientAdvisoryServicesReservationsController;
use App\Http\Controllers\Site\Lawyer\ClientServiceRequests\ClientServiceRequestsController;
use App\Http\Controllers\Site\Lawyer\ContactYmtaz\ContactYmtazController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\ElectronicOfficeController;
use App\Http\Controllers\Site\Lawyer\LawyerSiteController;
use App\Http\Controllers\Site\Lawyer\OrganizationRequests\OrganizationRequestsController;
use App\Http\Controllers\Site\Lawyer\Password\RestorePasswordController;
use App\Http\Controllers\Site\Lawyer\Services\LawyerServicesSiteController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'lawyer', 'as' => 'lawyer.'], function () {
    Route::get('/em-login', [LawyerAuthController::class, 'showEmptyLogin'])->name('show-em-login');
    Route::get('/sign-in/form', [LawyerAuthController::class, 'showLoginForm'])->name('show.login.form');
    Route::post('/login', [LawyerAuthController::class, 'postLogin'])->name('post.login');
    Route::get('/logout', [LawyerAuthController::class, 'logout'])->name('logout');
    Route::get('/register/form', [RegisterLawyerController::class, 'showRegisterForm'])->name('show.register.form');
    Route::post('save/register/data', [RegisterLawyerController::class, 'saveRegisterData'])->name('save.register.data');
    Route::get('activate/account/{email}/{otp}', [RegisterLawyerController::class, 'ShowActivateForm'])->name('show.activate.form');

    Route::get('activate/account/sms/{email}/{phone_code}/{phone}', [RegisterLawyerController::class, 'ShowActivateSMSForm'])->name('show.activate.sms.form');
    Route::post('activate/account/sms', [RegisterLawyerController::class, 'PostActivateSMS'])->name('post.activate.sms.form');

    Route::get('check/degree/{id?}', [RegisterLawyerController::class, 'CheckDegree'])->name('check.degree');
    Route::get('check/section/{id?}', [RegisterLawyerController::class, 'CheckSection'])->name('check.section');

    Route::get('/search-lawyers', [LawyerSiteController::class, 'searchLaywers'])->name('search');
    Route::get('get-regions-bade-country-id/{id?}', [RegisterLawyerController::class, 'getRegionsBaseCountryId'])->name('get-regions-bade-country-id');
    Route::get('get-cities-bade-region-id/{id?}', [RegisterLawyerController::class, 'getCitiesBaseRegionId'])->name('get-cities-bade-region-id');
    Route::get('get-districts-bade-city-id/{id?}', [RegisterLawyerController::class, 'getDistrictsBaseCityId'])->name('get-districts-bade-city-id');

    Route::post('update/data', [LawyerSiteController::class, 'updateRegisterData'])->name('update.register.data');
    Route::get('/show/{id}', [LawyerSiteController::class, 'show'])->name('show');
    Route::get('received-emails', [LawyerSiteController::class, 'lawyerReceivedEmails'])->name('received.email')->middleware('lawyer_auth');
    Route::get('/view-message/{id}', [LawyerSiteController::class, 'viewLawyerMessage'])->name('view.message')->middleware('lawyer_auth');


    Route::get('show-payment-rules', [LawyerSiteController::class, 'showPaymentRules'])->name('showPaymentRules')->middleware('lawyer_auth');
    Route::get('services-requests/{id?}', [LawyerSiteController::class, 'lawyerServicesRequests'])->name('services-requests')->middleware('lawyer_auth');
    Route::group(['prefix' => 'profile', 'as' => 'profile.',], function () {
        Route::get('/show', [LawyerSiteController::class, 'Profile'])->name('show')->middleware('auth:lawyer');
        Route::get('/edit/{id}', [LawyerSiteController::class, 'EditProfile'])->name('edit');
        Route::view('/success/update/data', 'site.success.success')->name('success-update-data');
        Route::get('/info', [LawyerSiteController::class, 'LawyerInformation'])->name('info')->middleware('auth:lawyer');
        Route::get('/delete-account', [LawyerSiteController::class, 'LawyerDeleteAccount'])->name('delete-account')->middleware('auth:lawyer');
        Route::post('/delete-account/save', [LawyerSiteController::class, 'SaveLawyerDeleteAccount'])->name('delete-account.post')->middleware('auth:lawyer');

    });
    Route::group(['prefix' => 'restore-password', 'as' => 'password.'], function () {
        Route::get('/', [RestorePasswordController::class, 'index'])->name('index');
        Route::post('/post-forgot', [RestorePasswordController::class, 'postForgotPassword'])->name('post-forgot');
        Route::view('/success/send/email', 'site.lawyers.password.restore_password_success')->name('success-send-email');
        Route::get('/reset-password/page/{hash}', [RestorePasswordController::class, 'resetPassword'])->name('reset-password');
        Route::post('/reset-password/{hash}', [RestorePasswordController::class, 'postResetPassword'])->name('post-reset-password');
    });
    Route::group(['prefix' => 'services', 'middleware' => 'lawyer_auth', 'as' => 'services.'], function () {
        Route::group(['prefix' => 'prices', 'as' => 'prices.'], function () {
            Route::get('/', [LawyerServicesSiteController::class, 'index'])->name('index');
            Route::post('/store', [LawyerServicesSiteController::class, 'store'])->name('store');
            Route::post('/checkserviceprice', [LawyerServicesSiteController::class, 'checkserviceprice'])->name('check');

        });
    });

    Route::group(['prefix' => 'organization-requests', 'middleware' => 'lawyer_auth', 'as' => 'organization-requests.'], function () {
        Route::get('/', [OrganizationRequestsController::class, 'index'])->name('index');
        Route::get('/create', [OrganizationRequestsController::class, 'create'])->name('create');
        Route::post('/store', [OrganizationRequestsController::class, 'store'])->name('store');
        Route::get('/show/{id}', [OrganizationRequestsController::class, 'show'])->name('show');
        Route::post('/saveorganizationrequestreply', [OrganizationRequestsController::class, 'saveorganizationrequestreply'])->name('saveorganizationrequestreply');

    });

    Route::group(['prefix' => 'contact-ymtaz', 'middleware' => 'lawyer_auth', 'as' => 'contact-ymtaz.'], function () {
        Route::get('/', [ContactYmtazController::class, 'index'])->name('index');
        Route::get('/create', [ContactYmtazController::class, 'create'])->name('create');
        Route::post('/store', [ContactYmtazController::class, 'store'])->name('store');
    });
    Route::group(['prefix' => 'clients-service-requests', 'middleware' => 'lawyer_auth', 'as' => 'clients-service-requests.'], function () {
        Route::get('/', [ClientServiceRequestsController::class, 'index'])->name('index');
        Route::get('/contact-client/{id}', [ClientServiceRequestsController::class, 'ShowRequestContacts'])->name('ShowRequestContacts');
        Route::post('/send-message', [ClientServiceRequestsController::class, 'SendRequestMessage'])->name('SendRequestMessage');
        Route::post('/send-final-replay', [ClientServiceRequestsController::class, 'SendFinalReplay'])->name('SendFinalReplay');
        Route::get('/show/{id}', [ClientServiceRequestsController::class, 'show'])->name('show');
        Route::post('/change-referral-status', [ClientServiceRequestsController::class, 'changeReferralStatus'])->name('changeReferralStatus');

    });
    Route::group(['prefix' => 'client-advisory-services-reservations', 'middleware' => 'lawyer_auth', 'as' => 'client_advisory_services_reservations.'], function () {
        Route::get('/', [ClientAdvisoryServicesReservationsController::class, 'index'])->name('index');
        Route::get('/contact-client/{id}', [ClientAdvisoryServicesReservationsController::class, 'ShowRequestContacts'])->name('ShowRequestContacts');
        Route::post('/send-message', [ClientAdvisoryServicesReservationsController::class, 'SendRequestMessage'])->name('SendRequestMessage');
        Route::post('/send-final-replay', [ClientAdvisoryServicesReservationsController::class, 'SendFinalReplay'])->name('SendFinalReplay');
        Route::get('/show/{id}', [ClientAdvisoryServicesReservationsController::class, 'show'])->name('show');

    });
    Route::group(['prefix' => 'administrative-office', 'middleware' => 'lawyer_auth', 'as' => 'administrative-office.'], function () {
        Route::get('/', [AdministrativeOfficeController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'electronic-office', 'as' => 'electronic-office.'], function () {
        Route::get('/', [ElectronicOfficeController::class, 'index'])->name('index');
        Route::get('/show', [ElectronicOfficeController::class, 'show'])->name('show');
    });

    include('web_site_electronic_office.php');

});
