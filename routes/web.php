<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YmtazSlotsController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\IdentityController;
use App\Http\Controllers\NewAdmin\BooksController;
use App\Http\Controllers\NewAdmin\RanksController;
use App\Http\Controllers\NewAdmin\LevelsController;
use App\Http\Controllers\NewAdmin\MailerController;
use App\Http\Controllers\NewAdmin\DegreesController;
use App\Http\Controllers\NewAdmin\StreaksController;
use App\Http\Controllers\NewAdmin\AppTextsController;
use App\Http\Controllers\NewAdmin\LawGuideController;
use App\Http\Controllers\NewAdmin\NewAdminController;
use App\Http\Controllers\NewAdmin\PackagesController;
use App\Http\Controllers\NewAdmin\ProductsController;
use App\Http\Controllers\NewAdmin\VisitorsController;
use App\Http\Controllers\Admin\ReservationsController;
use App\Http\Controllers\NewAdmin\BookGuideController;
use App\Http\Controllers\NewAdmin\LanguagesController;
use App\Http\Controllers\Admin\Client\ClientController;
use App\Http\Controllers\NewAdmin\ActivitiesController;
use App\Http\Controllers\NewAdmin\WhyChooseUsController;
use App\Http\Controllers\NewAdmin\LearningPathController;
use App\Http\Controllers\NewAdmin\NotificationController;
use App\Http\Controllers\NewAdmin\ProductCardsController;
use App\Http\Controllers\NewAdmin\WorkingHoursController;
use App\Http\Controllers\NewAdmin\JudicialGuideController;
use App\Http\Controllers\Admin\Services\ServicesController;
use App\Http\Controllers\NewAdmin\DashboardUsersController;
use App\Http\Controllers\NewAdmin\MailerAccountsController;
use App\Http\Controllers\NewAdmin\OrderingContentController;
use App\Http\Controllers\Admin\EliteServiceRequestsController;
use App\Http\Controllers\NewAdmin\ContactUsRequestsController;
use App\Http\Controllers\NewAdmin\ImportanceSettingsController;
use App\Http\Controllers\Admin\EliteServiceCategoriesController;
use App\Http\Controllers\Admin\Settings\Citites\CitiesController;
use App\Http\Controllers\Admin\Settings\Regions\RegionsController;
use App\Http\Controllers\Admin\DigitalGuide\DigitalGuideController;
use App\Http\Controllers\Admin\Settings\LawyerPermissionsController;
use App\Http\Controllers\Admin\Specialty\GeneralSpecialtyController;
use App\Http\Controllers\Admin\LawyerPayouts\LawyerPayoutsController;
use App\Http\Controllers\Admin\Specialty\AccurateSpecialtyController;
use App\Http\Controllers\Admin\EliteServicePricingCommitteeController;
use App\Http\Controllers\Admin\Settings\Countries\CountriesController;
use App\Http\Controllers\NewAdmin\ReservationsTypesSettingsController;
use App\Http\Controllers\Admin\FunctionalCases\FunctionalCasesController;
use App\Http\Controllers\NewAdmin\AvailableReservationsSettingsController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesController;
use App\Http\Controllers\Admin\Client\ServiceRequest\ServiceRequestController;
use App\Http\Controllers\Admin\Settings\Nationalities\NationalitiesController;
use App\Http\Controllers\API\Lawyer\Services\LawyerServicesRequestsController;
use App\Http\Controllers\Admin\AdvisoryCommittees\AdvisoryCommitteesController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesBaseController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesTypeController;
use App\Http\Controllers\Admin\Services\Categories\ServicesCategoriesController;
use App\Http\Controllers\Site\Client\ServicesRequests\ServicesRequestsController;
use App\Http\Controllers\Admin\OrganizationRequests\OrganizationRequestsController;
use App\Http\Controllers\Admin\AdvisoryCommittees\AdvisoryCommitteesMembersController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesReservationsController;
use App\Http\Controllers\Admin\DigitalGuide\Sections\DigitalGuideCategoriesAdminController;
use App\Http\Controllers\Site\Lawyer\ClientServiceRequests\ClientServiceRequestsController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesPaymentCategoriesController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesPaymentCategoryTypesController;
use App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\OrganizationRequest\OrganizationRequestController;
use Illuminate\Support\Facades\Auth;

$appUrl = config('app.url');

Route::group(['prefix' => 'newAdmin', 'as' => 'newAdmin.', 'middleware' => 'auth'], function () {
    Auth::routes(['register' => false]);
    // Admin panel routes here
    Route::get('/', function () {
        return redirect('newAdmin/dashboard');
    });
    Route::get('/home', function () {
        return redirect('newAdmin/dashboard');
    })->name('index');
    // Route::get('/', [NewAdminController::class, 'show']);
    Route::inertia('/login', 'Authentication/SignIn')->name('newAdminLogin')->middleware('guest');
    Route::get('/dashboard', [NewAdminController::class, 'showAnalytics']);
    Route::inertia('/tables', 'Tables');
    Route::get('/clients', [ClientController::class, 'newIndex'])->name('clientsIndex');
    Route::get('/clients/{id}/edit', [ClientController::class, 'EditView'])->name('clientEdit');
    Route::get('/lawyers', [DigitalGuideController::class, 'newIndex'])->name('lawyerIndex');
    Route::get('/lawyers/{id}/edit', [DigitalGuideController::class, 'EditView'])->name('lawyerEdit');
    Route::get('/old-clients', [ClientController::class, 'oldClientsIndex'])->name('oldClientsIndex');
    Route::get('/old-clients/{id}/edit', [ClientController::class, 'oldEditView'])->name('oldClientsEdit');
    Route::post('/old-clients/{id}', [ClientController::class, 'updateOld']);
    Route::get('/old-lawyers', [DigitalGuideController::class, 'oldLawyersIndex'])->name('oldLawyersIndex');
    Route::get('/old-lawyers/{id}/edit', [DigitalGuideController::class, 'oldEditView'])->name('oldLawyersEdit');
    Route::post('/old-lawyers/{id}', [DigitalGuideController::class, 'oldUpdate'])->name('oldLawyerUpdate');
    Route::delete('/old-lawyers/{id}', [DigitalGuideController::class, 'oldDestroy'])->name('oldLawyerDelete');
    Route::group(['prefix' => 'visitors', 'as' => 'visitors.'], function () {
        Route::get('/', [VisitorsController::class, 'index'])->name('index');
        Route::get('/{id}', [VisitorsController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [VisitorsController::class, 'update']);
        Route::get('/{id}/delete', [VisitorsController::class, 'destroy']);
    });
    Route::group(['prefix' => 'mailer-accounts', 'as' => 'mailer-accounts.'], function () {
        Route::get('/', [MailerAccountsController::class, 'index'])->name('index');
        Route::get('/{id}', [MailerAccountsController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [MailerAccountsController::class, 'update']);
        Route::get('/{id}/delete', [MailerAccountsController::class, 'destroy']);
    });
    Route::get('/services/categories', [ServicesCategoriesController::class, 'newIndex'])->name('settingsServicesCategoriesIndex');
    Route::get('/services/categories/create', [ServicesCategoriesController::class, 'create']);
    Route::get('/services/categories/{id}', [ServicesCategoriesController::class, 'edit'])->name('settingsServicesCategoriesEdit');
    Route::get('/services', [ServicesController::class, 'newIndex'])->name("servicesIndex");
    Route::get('/services/create', [ServicesController::class, 'create']);
    Route::get('/services/{id}', [ServicesController::class, 'edit'])->name('settingsServicesEdit');
    Route::post('/services/{id}/toggle', [ServicesController::class, 'toggle'])->name('services.toggle');
    Route::group(["prefix" => "contact-us-requests", "as" => "contact-us-requests."], function () {
        Route::get('/', [ContactUsRequestsController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactUsRequestsController::class, 'show'])->name('edit');
        Route::post('/{id}/update', [ContactUsRequestsController::class, 'update']);
    });

    Route::group(["prefix" => "mailer", "as" => "mailer."], function () {
        Route::get("/", [MailerController::class, "index"]);
        Route::post("/send-mail", [MailerController::class, "sendMail"]);
    });
    Route::group(["prefix" => "notifications", "as" => "notifications."], function () {
        Route::get("/", [NotificationController::class, "index"]);
        Route::post("/send-notification", [NotificationController::class, "sendNotification"]);
    });

    Route::group(['prefix' => 'services-requests', "as" => 'services-requests.'], function () {
        Route::redirect('/', '/newAdmin/services-requests/client');
        Route::get('/client', [ServiceRequestController::class, 'newIndexClient'])->name('client');
        Route::get('/lawyer', [ServiceRequestController::class, 'newIndexLawyer'])->name('lawyer');
        Route::get('/client/{id}', [ServiceRequestController::class, 'editClient'])->name('editClient');
        Route::get('/lawyer/{id}', [ServiceRequestController::class, 'editLawyer'])->name('editLawyer');
        Route::group(['prefix' => 'for-lawyer', 'as' => "for_lawyer."], function () {
            Route::get('/client', [ServiceRequestController::class, 'newIndexForLawyerFromClient'])->name('client');
            Route::get('/lawyer', [ServiceRequestController::class, 'newIndexForLawyerFromLawyer'])->name('lawyer');
            Route::get('/client/{id}', [ServiceRequestController::class, 'editClientForLawyer'])->name('editClient');
            Route::get('/lawyer/{id}', [ServiceRequestController::class, 'editLawyerForLawyer'])->name('editLawyer');
        });
    });
    Route::group(['prefix' => 'invoices', 'as' => "invoices."], function () {
        Route::get('/', [LawyerPayoutsController::class, 'invoices']);
        Route::get('/{id}', [LawyerPayoutsController::class, 'edit']);
        // Route::post('/update', [LawyerPayoutsController::class, 'update']);
    });
        Route::group(['prefix' => 'payouts', 'as' => "payouts."], function () {
        Route::get('/', [LawyerPayoutsController::class, 'index']);
        Route::get('/{id}', [LawyerPayoutsController::class, 'edit']);
        Route::post('/update', [LawyerPayoutsController::class, 'update']);
    });
    Route::group(['prefix' => 'advisory-services-requests', "as" => 'advisory-services-requests.'], function () {
        Route::redirect('/', '/newAdmin/advisory-services-requests/client');
        Route::get('/client', [AdvisoryServicesReservationsController::class, 'newIndexClient'])->name('client');
        Route::post('/clients/final-replay', [AdvisoryServicesReservationsController::class, 'SendFinalReplay']);
        Route::post('/lawyers/final-replay', [AdvisoryServicesReservationsController::class, 'SendFinalReplayLawyer']);
        Route::post('/clients/final-replay/forLawyer', [AdvisoryServicesReservationsController::class, 'SendFinalReplayForClientFromLawyer']);
        Route::post('/lawyers/final-replay/forLawyer', [AdvisoryServicesReservationsController::class, 'SendFinalReplayForLawyerFromLawyer']);
        Route::get('/lawyer', [AdvisoryServicesReservationsController::class, 'newIndexLawyer'])->name('lawyer');
        Route::get('/client/{id}', [AdvisoryServicesReservationsController::class, 'editClient'])->name('editClient');
        Route::get('/lawyer/{id}', [AdvisoryServicesReservationsController::class, 'editLawyer'])->name('editLawyer');
        Route::group(['prefix' => 'for-lawyer', 'as' => "for_lawyer."], function () {
            Route::get('/client', [AdvisoryServicesReservationsController::class, 'newIndexForLawyerFromClient'])->name('client');
            Route::get('/lawyer', [AdvisoryServicesReservationsController::class, 'newIndexForLawyerFromLawyer'])->name('lawyer');
            Route::get('/client/{id}', [AdvisoryServicesReservationsController::class, 'editClientForLawyer'])->name('editClient');
            Route::get('/lawyer/{id}', [AdvisoryServicesReservationsController::class, 'editLawyerForLawyer'])->name('editLawyer');
        });
    });
    Route::group(['prefix' => 'reservations-requests', "as" => 'reservations-requests.'], function () {
        Route::redirect('/', '/newAdmin/reservations-requests/client');
        Route::get('/client', [ReservationsController::class, 'indexClient'])->name('client');
        Route::post('/final-replay', [ReservationsController::class, 'SendFinalReplay']);
        Route::get('/lawyer', [ReservationsController::class, 'indexLawyer'])->name('lawyer');
        Route::get('/client/{id}', [ReservationsController::class, 'editClient'])->name('editClient');
        Route::get('/lawyer/{id}', [ReservationsController::class, 'editLawyer'])->name('editLawyer');
        Route::group(['prefix' => 'for-lawyer', 'as' => "for_lawyer."], function () {
            Route::get('/client', [ReservationsController::class, 'indexForLawyerFromClient'])->name('client');
            Route::get('/lawyer', [ReservationsController::class, 'indexForLawyerFromLawyer'])->name('lawyer');
            Route::get('/client/{id}', [ReservationsController::class, 'editClientForLawyer'])->name('editClient');
            Route::get('/lawyer/{id}', [ReservationsController::class, 'editLawyerForLawyer'])->name('editLawyer');
        });
    });
    Route::group(['prefix' => "settings", "as" => "settings."], function () {
        Route::group(['prefix' => 'working-hours', "as" => "working-hours."], function () {
            Route::get('/', [WorkingHoursController::class, 'index']);
            Route::post('/create', [WorkingHoursController::class, 'create']);
        });

        Route::group(['prefix' => 'learning-path', 'as' => 'learning_path.'], function () {
            Route::get('/', [LearningPathController::class, 'index'])->name('learning-path.index');
            Route::get('/create', [LearningPathController::class, 'create'])->name('learning-path.create');
            Route::post('/', [LearningPathController::class, 'store'])->name('learning-path.store');
            Route::get('/{id}/edit', [LearningPathController::class, 'edit'])->name('learning-path.edit');
            Route::put('/{id}', [LearningPathController::class, 'update'])->name('learning-path.update');
            Route::delete('/{id}', [LearningPathController::class, 'destroy'])->name('learning-path.destroy');
            Route::put('/order/update', [LearningPathController::class, 'updateOrder'])->name('learning-path.update-order');
        });

        Route::group(['prefix' => 'packages'], function () {
            Route::get('/', [PackagesController::class, 'index'])->name('index');
            Route::get('/create', [PackagesController::class, 'create'])->name('create');
            Route::get('/{id}', [PackagesController::class, 'edit'])->name('edit');
            Route::post('/store', [PackagesController::class, 'store'])->name('store');
            Route::post('/{id}', [PackagesController::class, 'update'])->name('update');
            Route::delete('/{id}', [PackagesController::class, 'destroy'])->name('delete');
        });
        Route::group(["prefix" => "importance", "as" => "importance."], function () {
            Route::get('/', [ImportanceSettingsController::class, 'index'])->name('index');
            Route::get('/create', [ImportanceSettingsController::class, 'createForm'])->name('create');
            Route::post('/create', [ImportanceSettingsController::class, 'create']);
            Route::get('/{id}', [ImportanceSettingsController::class, 'edit'])->name('edit');
            Route::delete('/{id}/delete', [ImportanceSettingsController::class, 'delete']);
            Route::post('/{id}/update', [ImportanceSettingsController::class, 'update']);
        });
        Route::group(["prefix" => "reservations", 'as' => 'reservations.'], function () {
            Route::group(['prefix' => 'available-reservations', 'as' => 'available-reservations.'], function () {
                Route::get('/', [AvailableReservationsSettingsController::class, 'index'])->name('index');
                Route::get('/create', [AvailableReservationsSettingsController::class, 'createForm'])->name('create');
                Route::post('/create', [AvailableReservationsSettingsController::class, 'create'])->name('create');
                Route::get('/{id}', [AvailableReservationsSettingsController::class, 'edit'])->name('edit');
                Route::get('/{id}/delete', [AvailableReservationsSettingsController::class, 'destroy']);
                Route::post('/{id}/update', [AvailableReservationsSettingsController::class, 'update']);

            });
            Route::group(['prefix' => 'types', 'as' => 'types.'], function () {
                Route::get('/', [ReservationsTypesSettingsController::class, 'index'])->name('index');
                Route::get('/create', [ReservationsTypesSettingsController::class, 'createForm'])->name('create');
                Route::post('/create', [ReservationsTypesSettingsController::class, 'create'])->name('create');
                Route::get('/{id}', [ReservationsTypesSettingsController::class, 'edit'])->name('edit');
                Route::get('/{id}/delete', [ReservationsTypesSettingsController::class, 'destroy']);
                Route::post('/{id}/update', [ReservationsTypesSettingsController::class, 'update']);
                Route::post('/{id}/toggle', [ReservationsTypesSettingsController::class, 'toggle'])->name('reservations.types.toggle');
            });
        });
        Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
            Route::group(['prefix' => 'users', 'as' => 'users'], function () {
                Route::get('/', [DashboardUsersController::class, 'index'])->name('index');
                Route::get('/create', [DashboardUsersController::class, 'indexCreate'])->name('create');
                Route::post('/create', [DashboardUsersController::class, 'create'])->name('create');
                Route::get('/{id}', [DashboardUsersController::class, 'indexEdit'])->name('edit');
                Route::post('/{id}', [DashboardUsersController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [DashboardUsersController::class, 'delete'])->name('edit');
            });
        });
        Route::group(
            ['prefix' => 'law-guide', 'as' => 'law_guide.'],
            function () {
                Route::redirect('/', '/newAdmin/law-guide/main');
                Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
                    Route::get('/', [LawGuideController::class, 'mainIndex'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('index');
                    Route::get('/create', [LawGuideController::class, 'mainIndexCreate'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::post('/create', [LawGuideController::class, 'createMain'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::get('/{id}', [LawGuideController::class, 'mainIndexEdit'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('edit');
                    Route::post('/{id}', [LawGuideController::class, 'editMain'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('edit');
                    Route::delete('/{id}', [LawGuideController::class, 'deleteMain'])->middleware('role_or_permission:manage-law-guide|super-admin|delete-law-guide')->name('edit');
                    Route::put('/order/update', [LawGuideController::class, 'updateMainOrder'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('update-order');
                });
                Route::group(['prefix' => 'sub', 'as' => 'sub.'], function () {
                    Route::get('/', [LawGuideController::class, 'subIndex'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('index');
                    Route::get('/create', [LawGuideController::class, 'subIndexCreate'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::post('/create', [LawGuideController::class, 'createSub'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::get('/{id}', [LawGuideController::class, 'subIndexEdit'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('edit');
                    Route::post('/{id}', [LawGuideController::class, 'editSub'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('edit');
                    Route::delete('/{id}', [LawGuideController::class, 'deleteSub'])->middleware('role_or_permission:manage-law-guide|super-admin|delete-law-guide')->name('edit');
                    Route::put('/order/update', [LawGuideController::class, 'updateSubOrder'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('update-order');
                });

                // Add routes for managing relationships
                Route::post('/{id}/related', [LawGuideController::class, 'storeRelatedGuides'])->name('related.store');
                Route::post('/laws/{id}/related', [LawGuideController::class, 'storeRelatedLaws'])->name('laws.related.store');
            }
        );
        Route::group(
            ['prefix' => 'book-guide', 'as' => 'book.'],
            function () {
                Route::redirect('/', '/newAdmin/book-guide/main');
                Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
                    Route::get('/', [BookGuideController::class, 'mainIndex'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('index');
                    Route::get('/create', [BookGuideController::class, 'mainIndexCreate'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::post('/create', [BookGuideController::class, 'createMain'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::get('/{id}', [BookGuideController::class, 'mainIndexEdit'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('edit');
                    Route::post('/{id}', [BookGuideController::class, 'editMain'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('edit');
                    Route::delete('/{id}', [BookGuideController::class, 'deleteMain'])->middleware('role_or_permission:manage-law-guide|super-admin|delete-law-guide')->name('edit');
                });
                Route::group(['prefix' => 'sub', 'as' => 'sub.'], function () {
                    Route::get('/', [BookGuideController::class, 'subIndex'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('index');
                    Route::get('/create', [BookGuideController::class, 'subIndexCreate'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::post('/create', [BookGuideController::class, 'createSub'])->middleware('role_or_permission:manage-law-guide|super-admin|create-law-guide')->name('create');
                    Route::get('/{id}', [BookGuideController::class, 'subIndexEdit'])->middleware('role_or_permission:manage-law-guide|super-admin|read-law-guide')->name('edit');
                    Route::post('/{id}', [BookGuideController::class, 'editSub'])->middleware('role_or_permission:manage-law-guide|super-admin|update-law-guide')->name('edit');
                    Route::delete('/{id}', [BookGuideController::class, 'deleteSub'])->middleware('role_or_permission:manage-law-guide|super-admin|delete-law-guide')->name('edit');
                });
            }
        );
        Route::group(['prefix' => 'books', 'as' => 'books.'], function () {
            Route::group(['prefix' => 'main', 'as' => 'main.'], function () {
                Route::get('/', [BooksController::class, 'mainIndex'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('index');
                Route::get('/create', [BooksController::class, 'mainIndexCreate'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('createView');
                Route::post('/create', [BooksController::class, 'createMain'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('create');
                Route::get('/{id}', [BooksController::class, 'mainIndexEdit'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('editView');
                Route::post('/{id}', [BooksController::class, 'editMain'])->middleware('role_or_permission:manage-books|super-admin|update-books')->name('edit');
                Route::delete('/{id}', [BooksController::class, 'deleteMain'])->middleware('role_or_permission:manage-books|super-admin|delete-books')->name('delete');
            });
            Route::group(['prefix' => 'sub', 'as' => 'sub.'], function () {
                Route::get('/', [BooksController::class, 'subIndex'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('index');
                Route::get('/create', [BooksController::class, 'subIndexCreate'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('createView');
                Route::post('/create', [BooksController::class, 'createSub'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('create');
                Route::get('/{id}', [BooksController::class, 'subIndexEdit'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('editView');
                Route::post('/{id}', [BooksController::class, 'editSub'])->middleware('role_or_permission:manage-books|super-admin|update-books')->name('edit');
                Route::delete('/{id}', [BooksController::class, 'deleteSub'])->middleware('role_or_permission:manage-books|super-admin|delete-books')->name('delete');
            });
            Route::get('/', [BooksController::class, 'index'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('index');
            Route::get('/create', [BooksController::class, 'indexCreate'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('createView');
            Route::post('/create', [BooksController::class, 'create'])->middleware('role_or_permission:manage-books|super-admin|create-books')->name('create');
            Route::get('/{id}', [BooksController::class, 'indexEdit'])->middleware('role_or_permission:manage-books|super-admin|read-books')->name('editView');
            Route::post('/{id}', [BooksController::class, 'edit'])->middleware('role_or_permission:manage-books|super-admin|update-books')->name('edit');
            Route::delete('/{id}', [BooksController::class, 'delete'])->middleware('role_or_permission:manage-books|super-admin|delete-books')->name('delete');

        });
        Route::group(['prefix' => 'banners', 'as' => 'banners.'], function () {
            Route::get('/', [BannersController::class, 'index'])->middleware('role_or_permission:super-admin')->name('index');
            Route::get('/create', [BannersController::class, 'create'])->middleware('role_or_permission:super-admin')->name('createView');
            Route::post('/create', [BannersController::class, 'store'])->middleware('role_or_permission:super-admin')->name('create');
            Route::get('/{id}', [BannersController::class, 'edit'])->middleware('role_or_permission:super-admin')->name('editView');
            Route::post('/{id}', [BannersController::class, 'update'])->middleware('role_or_permission:super-admin')->name('edit');
            Route::delete('/{id}', [BannersController::class, 'destroy'])->middleware('role_or_permission:super-admin')->name('delete');
        });
        Route::group(['prefix' => 'identity', 'as' => 'identity.'], function () {
            Route::get('/', [IdentityController::class, 'index'])->middleware('role_or_permission:super-admin')->name('index');
            Route::post('/', [IdentityController::class, 'update'])->middleware('role_or_permission:super-admin')->name('edit');
        });
        Route::group(['prefix' => 'judicial-guide', 'as' => 'judicial-guide.'], function () {
            Route::group(['prefix' => 'main', 'as' => 'main.'], function () {

                Route::get('/', [JudicialGuideController::class, 'mainIndex'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('index');
                Route::get('/create', [JudicialGuideController::class, 'mainIndexCreate'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
                Route::post('/create', [JudicialGuideController::class, 'createMain'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
                Route::get('/{id}', [JudicialGuideController::class, 'mainIndexEdit'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('edit');
                Route::post('/{id}', [JudicialGuideController::class, 'editMain'])->middleware('role_or_permission:manage-judicial-guide|super-admin|update-judicial-guide')->name('edit');
                Route::delete('/{id}', [JudicialGuideController::class, 'deleteMain'])->middleware('role_or_permission:manage-judicial-guide|super-admin|delete-judicial-guide')->name('edit');
            });
            Route::group(['prefix' => 'sub', 'as' => 'sub.'], function () {
                Route::get('/', [JudicialGuideController::class, 'subIndex'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('index');
                Route::get('/create', [JudicialGuideController::class, 'subIndexCreate'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
                Route::post('/create', [JudicialGuideController::class, 'createSub'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
                Route::get('/{id}', [JudicialGuideController::class, 'subIndexEdit'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('edit');
                Route::post('/{id}', [JudicialGuideController::class, 'editSub'])->middleware('role_or_permission:manage-judicial-guide|super-admin|update-judicial-guide')->name('edit');
                Route::delete('/{id}', [JudicialGuideController::class, 'deleteSub'])->middleware('role_or_permission:manage-judicial-guide|super-admin|delete-judicial-guide')->name('edit');
            });
            Route::get('/dashboard', action: [JudicialGuideController::class, 'dashboardIndex'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('index');
            Route::get('/', [JudicialGuideController::class, 'index'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('index');
            Route::get('/create', [JudicialGuideController::class, 'indexCreate'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
            Route::post('/create', [JudicialGuideController::class, 'create'])->middleware('role_or_permission:manage-judicial-guide|super-admin|create-judicial-guide')->name('create');
            Route::get('/{id}', [JudicialGuideController::class, 'indexEdit'])->middleware('role_or_permission:manage-judicial-guide|super-admin|read-judicial-guide')->name('edit');
            Route::post('/{id}', [JudicialGuideController::class, 'edit'])->middleware('role_or_permission:manage-judicial-guide|super-admin|update-judicial-guide')->name('edit');
            Route::delete('/{id}', [JudicialGuideController::class, 'delete'])->middleware('role_or_permission:manage-judicial-guide|super-admin|delete-judicial-guide')->name('edit');
        });
        Route::group(['prefix' => 'lawyer-permissions', 'as' => 'lawyer-permissions.'], function () {
            Route::get('/', [LawyerPermissionsController::class, 'index'])->name('index');
            Route::get('/{id}', [LawyerPermissionsController::class, 'edit'])->name('edit');
            Route::post('/{id}', [LawyerPermissionsController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => "products", 'as' => "products."], function () {
            Route::get('/', [ProductsController::class, 'index']);
            Route::get('/advisory-services', [ProductsController::class, 'advisoryServices']);
            Route::get('/services', [ProductsController::class, 'indexServices']);
        });
        Route::group(['prefix' => "advisory-services", 'as' => 'advisory_services.'], function () {
            Route::group(['prefix' => 'base', 'as' => 'base.'], function () {
                Route::get('/', [AdvisoryServicesBaseController::class, 'newIndex'])->name('index');
                Route::get('/create', [AdvisoryServicesBaseController::class, 'create'])->name('create');
                Route::get('/{id}', [AdvisoryServicesBaseController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'types', 'as' => 'types.'], function () {
                Route::get('/', [AdvisoryServicesTypeController::class, 'newIndex'])->name('index');
                Route::get('/create', [AdvisoryServicesTypeController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [AdvisoryServicesTypeController::class, 'newEdit'])->name('edit');
                Route::post('/{id}/toggle', [AdvisoryServicesTypeController::class, 'toggle'])->name('advisory-services.types.toggle');
            });
            Route::group(['prefix' => 'payment-categories', 'as' => 'payment_categories.'], function () {
                Route::get('/', [AdvisoryServicesPaymentCategoriesController::class, 'newIndex'])->name('index');
                Route::get('/create', [AdvisoryServicesPaymentCategoriesController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [AdvisoryServicesPaymentCategoriesController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'payment-categories-types', 'as' => 'payment-categories-types.'], function () {
                Route::get('/', [AdvisoryServicesPaymentCategoryTypesController::class, 'index'])->name('index');
                Route::get('/create', [AdvisoryServicesPaymentCategoryTypesController::class, 'create'])->name('create');
                Route::get('/{id}', [AdvisoryServicesPaymentCategoryTypesController::class, 'edit'])->name('edit');
                Route::post('/create', [AdvisoryServicesPaymentCategoryTypesController::class, 'store']);
                Route::post('/{id}', [AdvisoryServicesPaymentCategoryTypesController::class, 'update']);
            });
            Route::group(['prefix' => 'general-categories', 'as' => 'general-categories.'], function () {
                Route::get('/', [AdvisoryServicesController::class, 'generalCategoriesIndex'])->name('index');
                Route::get('/create', [AdvisoryServicesController::class, 'generalCategoriesCreate'])->name('create');
                Route::post('/store', [AdvisoryServicesController::class, 'generalCategoriesStore'])->name('store');
                Route::get('/{id}/edit', [AdvisoryServicesController::class, 'generalCategoriesEdit'])->name('edit');
                Route::post('/{id}/update', [AdvisoryServicesController::class, 'generalCategoriesUpdate'])->name('update');
                Route::delete('/{id}', [AdvisoryServicesController::class, 'generalCategoriesDestroy'])->name('destroy');
            });
            Route::group(['prefix' => 'sub-categories', 'as' => 'sub-categories.'], function () {
                Route::get('/', [AdvisoryServicesController::class, 'subCategoriesIndex'])->name('index');
                Route::get('/create', [AdvisoryServicesController::class, 'subCategoriesCreate'])->name('create');
                Route::post('/store', [AdvisoryServicesController::class, 'subCategoriesStore'])->name('store');
                Route::get('/{id}/edit', [AdvisoryServicesController::class, 'subCategoriesEdit'])->name('edit');
                Route::post('/{id}/update', [AdvisoryServicesController::class, 'subCategoriesUpdate'])->name('update');
                Route::delete('/{id}', [AdvisoryServicesController::class, 'subCategoriesDestroy'])->name('destroy');
                Route::post('/{id}/toggle-visibility', [AdvisoryServicesController::class, 'toggleSubCategoryVisibility'])->name('toggle-visibility');
            });
            Route::get('/', [AdvisoryServicesController::class, 'newIndex'])->name('index');
            Route::get('/create', [AdvisoryServicesController::class, 'newCreate'])->name('create');
            Route::get('/{id}', [AdvisoryServicesController::class, 'newEdit'])->name('edit');
        });
        Route::group(['prefix' => "gamification", 'as' => "gamification."], function () {
            Route::group(['prefix' => 'levels', 'as' => 'levels.'], function () {
                Route::get('/', [LevelsController::class, 'index'])->name('indexView');
                Route::get('/create', [LevelsController::class, 'indexCreate'])->name('createView');
                Route::get('/{id}', [LevelsController::class, 'indexEdit'])->name('editView');
                Route::post('/create', [LevelsController::class, 'create'])->name('create');
                Route::post('/{id}', [LevelsController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [LevelsController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'ranks', 'as' => 'ranks.'], function () {
                Route::get('/', [RanksController::class, 'index'])->name('indexView');
                Route::get('/create', [RanksController::class, 'indexCreate'])->name('createView');
                Route::get('/{id}', [RanksController::class, 'indexEdit'])->name('editView');
                Route::post('/create', [RanksController::class, 'create'])->name('create');
                Route::post('/{id}', [RanksController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [RanksController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'activities', 'as' => 'activities.'], function () {
                Route::get('/', [ActivitiesController::class, 'index'])->name('indexView');
                Route::get('/create', [ActivitiesController::class, 'indexCreate'])->name('createView');
                Route::get('/{id}', [ActivitiesController::class, 'indexEdit'])->name('editView');
                Route::post('/create', [ActivitiesController::class, 'create'])->name('create');
                Route::post('/{id}', [ActivitiesController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [ActivitiesController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'streaks', 'as' => 'streaks.'], function () {
                Route::get('/', [StreaksController::class, 'index'])->name('indexView');
                Route::get('/create', [StreaksController::class, 'indexCreate'])->name('createView');
                Route::get('/{id}', [StreaksController::class, 'indexEdit'])->name('editView');
                Route::post('/create', [StreaksController::class, 'create'])->name('create');
                Route::post('/{id}', [StreaksController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [StreaksController::class, 'delete'])->name('delete');
            });
        });
        Route::group(['prefix' => 'signup', "as" => "signup."], function () {
            Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
                Route::get('/', [DigitalGuideCategoriesAdminController::class, 'newIndex'])->name('index');
                Route::get('/create', [DigitalGuideCategoriesAdminController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [DigitalGuideCategoriesAdminController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'degrees', 'as' => 'degrees.'], function () {
                Route::get('/', [DegreesController::class, 'index'])->name('indexView');
                Route::get('/create', [DegreesController::class, 'indexCreate'])->name('createView');
                Route::get('/{id}', [DegreesController::class, 'indexEdit'])->name('editView');
                Route::post('/create', [DegreesController::class, 'create'])->name('create');
                Route::post('/{id}', [DegreesController::class, 'edit'])->name('edit');
                Route::delete('/{id}', [DegreesController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'languages', 'as' => 'languages.'], function () {
                Route::get('/', [LanguagesController::class, 'index'])->name('indexView');
                Route::get('/create', [LanguagesController::class, 'create'])->name('createView');
                Route::get('/{id}', [LanguagesController::class, 'edit'])->name('editView');
                Route::post('/create', [LanguagesController::class, 'store'])->name('create');
                Route::post('/{id}', [LanguagesController::class, 'update'])->name('edit');
                Route::delete('/{id}', [LanguagesController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
                Route::get('/', [CountriesController::class, 'newIndex'])->name('index');
                Route::get('/create', [CountriesController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [CountriesController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'nationalities', 'as' => 'nationalities.'], function () {
                Route::get('/', [NationalitiesController::class, 'newIndex'])->name('index');
                Route::get('/create', [NationalitiesController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [NationalitiesController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
                Route::get('/', [RegionsController::class, 'newIndex'])->name('index');
                Route::get('/create', [RegionsController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [RegionsController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'cities', 'as' => 'cities.'], function () {
                Route::get('/', [CitiesController::class, 'newIndex'])->name('index');
                Route::get('/create', [CitiesController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [CitiesController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'general-specialty', 'as' => 'general-specialty.'], function () {
                Route::get('/', [GeneralSpecialtyController::class, 'newIndex'])->name('index');
                Route::get('/create', [GeneralSpecialtyController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [GeneralSpecialtyController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'accurate-specialty', 'as' => 'accurate-specialty.'], function () {
                Route::get('/', [AccurateSpecialtyController::class, 'newIndex'])->name('index');
                Route::get('/create', [AccurateSpecialtyController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [AccurateSpecialtyController::class, 'newEdit'])->name('edit');
            });
            Route::group(['prefix' => 'functional-cases', 'as' => 'functional-cases.'], function () {
                Route::get('/', [FunctionalCasesController::class, 'newIndex'])->name('index');
                Route::get('/create', [FunctionalCasesController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [FunctionalCasesController::class, 'newEdit'])->name('edit');
            });
        });
        Route::group(['prefix' => 'landing-page', 'as' => 'landing-page.'], function () {
            Route::group(['prefix' => 'ordering-content', 'as' => 'ordering-content.'], function () {
                Route::get('/', [OrderingContentController::class, 'index'])->name('index');
                Route::post('/update', [OrderingContentController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'product-cards', 'as' => 'product-cards.'], function () {
                Route::get('/', [ProductCardsController::class, 'index'])->name('index');
                Route::post('/update', [ProductCardsController::class, 'update'])->name('update');
            });
            Route::group(['prefix' => 'why-choose-us', 'as' => 'why-choose-us.'], function () {
                Route::get('/', [WhyChooseUsController::class, 'index'])->name('index');
                Route::post('/update', [WhyChooseUsController::class, 'update'])->name('update');
            });
        });

        Route::group(["prefix" => "advisory-committees", "as" => "advisory-committees."], function () {
            Route::group(["prefix" => "lawyers", "as" => "lawyers."], function () {
                Route::get('/', [AdvisoryCommitteesMembersController::class, 'newIndex'])->name('index');
                Route::get('/create', [AdvisoryCommitteesMembersController::class, 'newCreate'])->name('create');
                Route::get('/{id}', [AdvisoryCommitteesMembersController::class, 'newEdit'])->name('edit');
            });
            Route::get('/', [AdvisoryCommitteesController::class, 'newIndex'])->name('index');
            Route::get('/create', [AdvisoryCommitteesController::class, 'newCreate'])->name('create');
            Route::get('/{id}', [AdvisoryCommitteesController::class, 'newEdit'])->name('edit');
        });
        Route::group(['prefix' => 'app-texts'], function () {
            Route::get('/', [AppTextsController::class, 'index'])->name('index');
            Route::post('/update', [AppTextsController::class, 'update'])->name('update');

        });
        Route::group(['prefix' => 'learning-path', 'as' => 'learning-path.'], function () {
            Route::get('/', [LearningPathController::class, 'index'])->name('index');
            Route::get('/create', [LearningPathController::class, 'create'])->name('create');
            Route::post('/store', [LearningPathController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LearningPathController::class, 'edit'])->name('edit');
            Route::post('/{id}', [LearningPathController::class, 'update'])->name('update');
            Route::delete('/{id}', [LearningPathController::class, 'destroy'])->name('destroy');
        });
        Route::group(['prefix' => "elite-service-categories", "as" => "elite-service-categories."], function () {
            Route::get('/', [EliteServiceCategoriesController::class, 'index'])->name('index');
            Route::get('/create', [EliteServiceCategoriesController::class, 'create'])->name('create');
            Route::post('/create', [EliteServiceCategoriesController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EliteServiceCategoriesController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EliteServiceCategoriesController::class, 'update'])->name('update');
            Route::delete('/{id}', [EliteServiceCategoriesController::class, 'destroy'])->name('destroy');
        });
    });

    Route::group(['prefix' => 'ymtaz-slots'], function () {
        Route::get('/', [YmtazSlotsController::class, 'index'])->name('ymtazslots.index');
        Route::post('/{slotId}/update', [YmtazSlotsController::class, 'updateAssignees'])->name('ymtazslots.updateAssignees');
    });

    // Elite Service Requests
    Route::get('/elite-service-requests', [EliteServiceRequestsController::class, 'index'])->name('elite-service-requests.index');
    Route::get('/elite-service-requests/{id}', [EliteServiceRequestsController::class, 'show'])->name('elite-service-requests.show');
    Route::post('/elite-service-requests/{id}/assign-pricer', [EliteServiceRequestsController::class, 'assignPricer'])->name('elite-service-requests.assign-pricer');

    // Elite Service Pricing Committee
    Route::prefix('settings')->group(function () {
        Route::get('/elite-service-pricing-committee', [EliteServicePricingCommitteeController::class, 'index'])->name('elite-service-pricing-committee.index');
        Route::post('/elite-service-pricing-committee', [EliteServicePricingCommitteeController::class, 'store'])->name('elite-service-pricing-committee.store');
        Route::post('/elite-service-pricing-committee/{id}/toggle-active', [EliteServicePricingCommitteeController::class, 'toggleActive'])->name('elite-service-pricing-committee.toggle-active');
        Route::delete('/elite-service-pricing-committee/{id}', [EliteServicePricingCommitteeController::class, 'destroy'])->name('elite-service-pricing-committee.destroy');
    });

});
