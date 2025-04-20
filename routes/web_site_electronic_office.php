<?php


use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Auth\ElectronicOfficeLawyerAuthController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Clients\ClientsController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\ContactYmtaz\ContactYmtazController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\ElectronicOfficeDashboardController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\OrganizationRequest\OrganizationRequestController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Services\ServicesController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Settings\SettingsController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\ElectronicOfficeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'electronic-office', 'as' => 'electronic-office.'], function () {
    Route::get('/{electronic_id_code}', [ElectronicOfficeController::class, 'index'])->name('home');
    Route::get('/services/{electronic_id_code}', [ElectronicOfficeController::class, 'services'])->name('services');
    Route::get('/services/show/{id}/{electronic_id_code}', [ElectronicOfficeController::class, 'servicesShow'])->name('servicesShow');
    Route::get('/clients/{electronic_id_code}', [ElectronicOfficeController::class, 'clients'])->name('clients');
    Route::get('/blog/{electronic_id_code}', [ElectronicOfficeController::class, 'blog'])->name('blog');
    Route::get('/login/{electronic_id_code}', [ElectronicOfficeLawyerAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('post/login', [ElectronicOfficeLawyerAuthController::class, 'postLogin'])->name('post.login');
    Route::get('logout/{electronic_id_code}', [ElectronicOfficeLawyerAuthController::class, 'logout'])->name('logout')->middleware('auth:lawyer_electronic_office');

    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'auth:lawyer_electronic_office'], function () {
        Route::get('/{electronic_id_code}', [ElectronicOfficeDashboardController::class, 'index'])->name('index');
        Route::group(['prefix' => 'services', 'as' => 'services.'], function () {
            Route::get('/{electronic_id_code}', [ServicesController::class, 'index'])->name('index');
            Route::get('/create/{electronic_id_code}', [ServicesController::class, 'create'])->name('create');
            Route::post('/store', [ServicesController::class, 'store'])->name('store');
            Route::get('edit/{id}/{electronic_id_code}', [ServicesController::class, 'edit'])->name('edit');
            Route::post('/update', [ServicesController::class, 'update'])->name('update');
            Route::get('show/{id}/{electronic_id_code}', [ServicesController::class, 'show'])->name('show');
            Route::get('delete/{id}/{electronic_id_code}', [ServicesController::class, 'destroy'])->name('delete');
        });
        Route::group(['prefix' => 'contact-ymtaz', 'as' => 'contact-ymtaz.'], function () {
            Route::get('/{electronic_id_code}', [ContactYmtazController::class, 'index'])->name('index');
            Route::get('create/{electronic_id_code}', [ContactYmtazController::class, 'create'])->name('create');
            Route::post('store', [ContactYmtazController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'organization-request', 'as' => 'organization-request.'], function () {
            Route::get('/{electronic_id_code}', [OrganizationRequestController::class, 'index'])->name('index');
            Route::get('create/{electronic_id_code}', [OrganizationRequestController::class, 'create'])->name('create');
            Route::post('store', [OrganizationRequestController::class, 'store'])->name('store');
            Route::get('/show/{id}/{electronic_id_code}', [OrganizationRequestController::class, 'show'])->name('show');
            Route::post('/saveorganizationrequestreply/', [OrganizationRequestController::class, 'saveorganizationrequestreply'])->name('saveorganizationrequestreply');
        });
        Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
            Route::get('/{electronic_id_code}', [ClientsController::class, 'index'])->name('index');
            Route::get('/create/{electronic_id_code}', [ClientsController::class, 'create'])->name('create');
            Route::post('/store', [ClientsController::class, 'store'])->name('store');
            Route::get('edit/{id}/{electronic_id_code}', [ClientsController::class, 'edit'])->name('edit');
            Route::post('/update', [ClientsController::class, 'update'])->name('update');
            Route::get('show/{id}/{electronic_id_code}', [ClientsController::class, 'show'])->name('show');
            Route::get('delete/{id}/{electronic_id_code}', [ClientsController::class, 'destroy'])->name('delete');
        });

        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('/{electronic_id_code}', [SettingsController::class, 'index'])->name('index');
            Route::post('/update', [SettingsController::class, 'update'])->name('update');

        });
    });
});
