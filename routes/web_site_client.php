<?php

use App\Http\Controllers\Site\Client\AdvisoryServices\ClientAdvisoryServicesController;
use App\Http\Controllers\Site\Client\Auth\ClientAuthController;
use App\Http\Controllers\Site\Client\Auth\ClientRegisterController;
use App\Http\Controllers\Site\Client\Complaints\ComplaintsController;
use App\Http\Controllers\Site\Client\Password\ResetPasswordController;
use App\Http\Controllers\Site\Client\Profile\ClientProfileController;
use App\Http\Controllers\Site\Client\ServicesRequests\ServicesRequestsController;
use App\Http\Controllers\Site\Client\YmtazContact\ClientYmtazContactController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
    Route::get('/em-login', [ClientAuthController::class, 'showEmptyLogin'])->name('show-em-login');
    Route::get('/sign-in/form', [ClientAuthController::class, 'showLoginForm'])->name('show.login.form');
    Route::post('/login', [ClientAuthController::class, 'postLogin'])->name('post.login');
    Route::get('/logout', [ClientAuthController::class, 'logout'])->name('logout');
    Route::get('/register/form', [ClientRegisterController::class, 'showRegisterForm'])->name('show.register.form');
    Route::post('save/register/data', [ClientRegisterController::class, 'saveRegisterData'])->name('save.register.data');
    Route::get('activate/account/{email}/{otp}', [ClientRegisterController::class, 'ClientActivateAccount'])->name('show.activate.form');
    Route::get('activate/account/sms', [ClientRegisterController::class, 'ShowActivateAccountForm'])->name('sms.show.activate.form');
    Route::post('activate/account/sms', [ClientRegisterController::class, 'PostActivateAccountForm'])->name('sms.post.activate.form');

    Route::post('/post-forgot-password', [ResetPasswordController::class, 'postForgotPassword'])->name('post-forgot-password');
    Route::get('/reset-password/{key}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password');
    Route::post('/reset-password/{hash}', [ResetPasswordController::class, 'postResetPassword'])->name('post-reset-password');

    Route::get('get-regions-bade-country-id-client/{id?}', [ClientRegisterController::class, 'getRegionsBaseCountryId'])->name('get-regions-bade-country-id');
    Route::get('get-cities-bade-region-id/{id?}', [ClientRegisterController::class, 'getCitiesBaseRegionId2'])->name('get-cities-bade-region-id');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ClientProfileController::class, 'index'])->name('index')->middleware('auth:client');
        Route::get('/edit/{id}', [ClientProfileController::class, 'edit'])->name('edit');
        Route::post('/update', [ClientProfileController::class, 'update'])->name('update');
        Route::get('/delete-account', [ClientProfileController::class, 'ClientDeleteAccount'])->name('delete-account')->middleware('auth:client');
        Route::post('/delete-account/save', [ClientProfileController::class, 'SaveClientDeleteAccount'])->name('delete-account.post')->middleware('auth:client');

    });
    Route::group(['prefix' => 'service-request', 'as' => 'service-request.', 'middleware' => 'auth:client'], function () {
        Route::get('/', [ServicesRequestsController::class, 'index'])->name('index');
        Route::get('/create/{id?}', [ServicesRequestsController::class, 'create'])->name('create');
        Route::get('/create-with-lawyer/{id}/{lawyer_id}', [ServicesRequestsController::class, 'createWithLawyer'])->name('createWithLawyer');
        Route::post('/storeWithLawyer', [ServicesRequestsController::class, 'storeWithLawyer'])->name('storeWithLawyer');
        Route::post('/store', [ServicesRequestsController::class, 'store'])->name('store');
        Route::get('/show-request-replies/{id}', [ServicesRequestsController::class, 'ShowRequestReplies'])->name('show-request-replies');
        Route::post('/send-client-replay', [ServicesRequestsController::class, 'SendClientRequestReplay'])->name('send-client-replay');
        Route::post('/client-rate-replay', [ServicesRequestsController::class, 'SendClientRateRequestReplay'])->name('client-rate-replay');

    });
    Route::group(['prefix' => 'advisory-services', 'as' => 'advisory-services.', 'middleware' => 'auth:client'], function () {
        Route::get('/', [ClientAdvisoryServicesController::class, 'index'])->name('index');
        Route::get('/create/{lawyer_id}', [ClientAdvisoryServicesController::class, 'create'])->name('create');
        Route::post('/store', [ClientAdvisoryServicesController::class, 'store'])->name('store');
    });
    Route::group(['prefix' => 'advisory-services', 'as' => 'advisory-services.'], function () {
        Route::get('/complete/payment/{id}', [ClientAdvisoryServicesController::class, 'CompletePaymentClientAdvisoryServices'])->name('CompletePaymentClientAdvisoryServices');
        Route::get('/cancel/payment/{id}', [ClientAdvisoryServicesController::class, 'CancelPaymentClientAdvisoryServices'])->name('CancelPaymentClientAdvisoryServices');
        Route::get('/declined/payment/{id}', [ClientAdvisoryServicesController::class, 'DeclinedPaymentClientAdvisoryServices'])->name('DeclinedPaymentClientAdvisoryServices');

    });
    Route::group(['prefix' => 'service-request', 'as' => 'service-request.'], function () {
        Route::get('/complete/payment/{id}', [ServicesRequestsController::class, 'CompletePaymentClientServicesRequests'])->name('CompletePaymentClientServicesRequests');
        Route::get('/cancel/payment/{id}', [ServicesRequestsController::class, 'CancelPaymentClientServicesRequests'])->name('CancelPaymentClientServicesRequests');
        Route::get('/declined/payment/{id}', [ServicesRequestsController::class, 'DeclinedPaymentClientServicesRequests'])->name('DeclinedPaymentClientServicesRequests');

    });
    Route::group(['prefix' => 'ymtaz-contact', 'as' => 'ymtaz-contact.', 'middleware' => 'auth:client'], function () {
        Route::get('/', [ClientYmtazContactController::class, 'index'])->name('index');
        Route::get('/create', [ClientYmtazContactController::class, 'create'])->name('create');
        Route::post('/store', [ClientYmtazContactController::class, 'store'])->name('store');

    });
    Route::group(['prefix' => 'visitor/service-request', 'as' => 'service-request.'], function () {
        Route::get('/create-client-service/{service_id}', [ServicesRequestsController::class, 'CreateClientService'])->name('create-visitor-service');
        Route::post('/store-client-service', [ServicesRequestsController::class, 'StoreClientService'])->name('store-client-service');
    });

    Route::group(['prefix' => 'complains', 'as' => 'complains.', 'middleware' => 'auth:client'], function () {
        Route::post('/store', [ComplaintsController::class, 'store'])->name('store');
    });

    Route::get('get-regions-bade-country-id/{id?}', [ClientRegisterController::class, 'getCitiesBaseRegionId'])->name('get-cities-bade-country-id');

});
