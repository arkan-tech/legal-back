<?php

use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Home\HomeController;
use App\Http\Controllers\Admin\Client\ClientController;
use App\Http\Controllers\Admin\Packages\PackagesController;
use App\Http\Controllers\Admin\Services\ServicesController;
use App\Http\Controllers\Admin\Splash\SplashSettingsController;
use App\Http\Controllers\Admin\Training\AdminTrainingController;
use App\Http\Controllers\Admin\Settings\Citites\CitiesController;
use App\Http\Controllers\Admin\Contacts\ContactMessagesController;
use App\Http\Controllers\Admin\Settings\Regions\RegionsController;
use App\Http\Controllers\Admin\DigitalGuide\DigitalGuideController;
use App\Http\Controllers\Admin\RequestLevel\RequestLevelController;
use App\Http\Controllers\Admin\TodayBenefit\TodayBenefitController;
use App\Http\Controllers\Admin\Complaints\AdminComplaintsController;
use App\Http\Controllers\Admin\Library\Books\BooksLibraryController;
use App\Http\Controllers\Admin\Specialty\GeneralSpecialtyController;
use App\Http\Controllers\Admin\Specialty\AccurateSpecialtyController;
use App\Http\Controllers\Admin\Settings\Countries\CountriesController;
use App\Http\Controllers\Admin\Settings\Districts\DistrictsController;
use App\Http\Controllers\Admin\FunctionalCases\FunctionalCasesController;
use App\Http\Controllers\Admin\Settings\LawyerTypes\LawyerTypesController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesController;
use App\Http\Controllers\Admin\Client\YmtazContacts\YmtazContactsController;
use App\Http\Controllers\Admin\Library\JudicialBlogs\JudicialBlogsController;
use App\Http\Controllers\Admin\Client\ServiceRequest\ServiceRequestController;
use App\Http\Controllers\Admin\Settings\Nationalities\NationalitiesController;
use App\Http\Controllers\Admin\AdvisoryCommittees\AdvisoryCommitteesController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesBaseController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesTypeController;
use App\Http\Controllers\Admin\ClientReservations\ClientReservationsController;
use App\Http\Controllers\Admin\Services\Categories\ServicesCategoriesController;
use App\Http\Controllers\Admin\Library\LibraryCategory\LibraryCategoryController;
use App\Http\Controllers\Admin\ClientReservations\ClientReservationsTypeController;
use App\Http\Controllers\Admin\OrganizationRequests\OrganizationRequestsController;
use App\Http\Controllers\Admin\YmtazContactMessages\YmtazContactMessagesController;
use App\Http\Controllers\Admin\ClientReservations\ClientYmtazReservationsController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesImportanceController;
use App\Http\Controllers\Admin\AdvisoryCommittees\AdvisoryCommitteesMembersController;
use App\Http\Controllers\Admin\Services\SubCategories\ServicesSubCategoriesController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesReservationsController;
use App\Http\Controllers\Admin\Settings\TermsAndConditions\TermsAndConditionsController;
use App\Http\Controllers\Admin\Library\RulesAndRegulations\RulesAndRegulationsController;
use App\Http\Controllers\Admin\Client\DeleteAccountRequest\DeleteAccountRequestController;
use App\Http\Controllers\Admin\Settings\SiteInformation\SiteInformationSettingsController;
use App\Http\Controllers\Admin\DigitalGuide\Sections\DigitalGuideCategoriesAdminController;
use App\Http\Controllers\Admin\AdvisoryServices\AdvisoryServicesPaymentCategoriesController;
use App\Http\Controllers\Admin\ClientLawyerReservationsAdmin\ClientLawyerReservationsAdminController;
use App\Http\Controllers\Admin\DigitalGuide\DeleteAccountRequest\DigitalGuideDeleteAccountRequestController;

use Illuminate\Support\Facades\Auth;

// Route::get('/{any}', function ($any) {
//     if ($any !== 'admin/login' && $any !== 'newAdmin/login') {
//         return redirect('/newAdmin/dashboard');
//     }
//     return redirect('/admin/login');
// })->where('any', '.*');

Route::group(['prefix' => 'admin'], function () {
    Auth::routes(['register' => false]);
    Route::group(['middleware' => 'auth', 'as' => 'admin.'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [HomeController::class, 'UpdateProfile'])->name('profile.update');
        Route::group(['prefix' => 'digital-guide', 'as' => 'digital-guide.'], function () {
            Route::resource('/', DigitalGuideController::class);
            Route::get('/export', [DigitalGuideController::class, 'ExportLawyers'])->name('export-lawyers');
            Route::get('{id}/edit', [DigitalGuideController::class, 'edit'])->name('editById');
            Route::get('get-regions-bade-country-id/{id?}', [DigitalGuideController::class, 'getRegionsBaseCountryId'])->name('get-regions-bade-country-id');
            Route::get('get-cities-bade-region-id/{id?}', [DigitalGuideController::class, 'getCitiesBaseRegionId'])->name('get-cities-bade-region-id');
            Route::get('get-districts-bade-city-id/{id?}', [DigitalGuideController::class, 'getDistrictsBaseCityId'])->name('get-districts-bade-city-id');
            Route::post('update', [DigitalGuideController::class, 'update'])->name('updateDigitalGuide');
            Route::get('/delete/{id}', [DigitalGuideController::class, 'destroy'])->name('delete');
            Route::get('/delete/section/{id}', [DigitalGuideController::class, 'DestroySection'])->name('delete.section');
            Route::get('/edit/section/{id}', [DigitalGuideController::class, 'EditSection'])->name('edit.section');
            Route::post('/update/section', [DigitalGuideController::class, 'UpdateSection'])->name('update.section');
            Route::group(['prefix' => 'packages', 'as' => 'packages.'], function () {
                Route::get('/', [PackagesController::class, 'index'])->name('index');
                Route::get('/create', [PackagesController::class, 'create'])->name('create');
                Route::post('/store', [PackagesController::class, 'store'])->name('store');
                Route::get('/delete/{id}', [PackagesController::class, 'destroy'])->name('delete');
                Route::get('/show/{id}', [PackagesController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [PackagesController::class, 'edit'])->name('edit');
                Route::post('/update', [PackagesController::class, 'update'])->name('update');

            });
            Route::group(['prefix' => 'delete-accounts', 'as' => 'delete-accounts.'], function () {
                Route::get('/', [DigitalGuideDeleteAccountRequestController::class, 'index'])->name('index');
                Route::get('show/{id}', [DigitalGuideDeleteAccountRequestController::class, 'show'])->name('show');
                Route::get('edit/{id}', [DigitalGuideDeleteAccountRequestController::class, 'edit'])->name('edit');
                Route::post('/update', [DigitalGuideDeleteAccountRequestController::class, 'update'])->name('update');
                Route::get('delete/{id}', [DigitalGuideDeleteAccountRequestController::class, 'destroy'])->name('delete');
            });
            Route::group(['prefix' => 'sections', 'as' => 'sections.'], function () {
                Route::get('/', [DigitalGuideCategoriesAdminController::class, 'index'])->name('index');
                Route::post('/store', [DigitalGuideCategoriesAdminController::class, 'store'])->name('store');
                Route::post('/update', [DigitalGuideCategoriesAdminController::class, 'update'])->name('update');
                Route::get('/show/{id}', [DigitalGuideCategoriesAdminController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [DigitalGuideCategoriesAdminController::class, 'edit'])->name('edit');
                Route::get('/delete/{id}', [DigitalGuideCategoriesAdminController::class, 'destroy'])->name('delete');
            });
        });
        Route::group(['prefix' => 'nationalities', 'as' => 'nationalities.'], function () {
            Route::get('/', [NationalitiesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [NationalitiesController::class, 'edit'])->name('edit');
            Route::post('update', [NationalitiesController::class, 'update'])->name('update');
            Route::get('delete/{id}', [NationalitiesController::class, 'destroy'])->name('delete');
            Route::post('store', [NationalitiesController::class, 'store'])->name('store');

        });
        Route::group(['prefix' => 'lawyer-types', 'as' => 'lawyer_types.'], function () {
            Route::get('/', [LawyerTypesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [LawyerTypesController::class, 'edit'])->name('edit');
            Route::post('update', [LawyerTypesController::class, 'update'])->name('update');
        });
        Route::group(['prefix' => 'countries', 'as' => 'countries.'], function () {
            Route::get('/', [CountriesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [CountriesController::class, 'edit'])->name('edit');
            Route::post('update', [CountriesController::class, 'update'])->name('update');
            Route::get('delete/{id}', [CountriesController::class, 'destroy'])->name('delete');
            Route::post('store', [CountriesController::class, 'store'])->name('store');

        });
        Route::group(['prefix' => 'regions', 'as' => 'regions.'], function () {
            Route::get('/', [RegionsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [RegionsController::class, 'edit'])->name('edit');
            Route::post('update', [RegionsController::class, 'update'])->name('update');
            Route::post('store', [RegionsController::class, 'store'])->name('store');
            Route::get('delete/{id}', [RegionsController::class, 'destroy'])->name('delete');
        });
        Route::group(['prefix' => 'cities', 'as' => 'cities.'], function () {
            Route::get('/', [CitiesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [CitiesController::class, 'edit'])->name('edit');
            Route::post('update', [CitiesController::class, 'update'])->name('update');
            Route::get('delete/{id}', [CitiesController::class, 'destroy'])->name('delete');
            Route::post('store', [CitiesController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'districts', 'as' => 'districts.'], function () {
            Route::get('/', [DistrictsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [DistrictsController::class, 'edit'])->name('edit');
            Route::post('update', [DistrictsController::class, 'update'])->name('update');
            Route::get('delete/{id}', [DistrictsController::class, 'destroy'])->name('delete');
            Route::post('store', [DistrictsController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
            Route::get('lawyer/terms-conditions', [TermsAndConditionsController::class, 'index'])->name('terms-conditions');
            Route::post('lawyer/terms-conditions', [TermsAndConditionsController::class, 'store'])->name('terms-conditions.update');

            Route::get('client/terms-conditions', [TermsAndConditionsController::class, 'ClientIndex'])->name('client.terms-conditions');
            Route::post('client/terms-conditions', [TermsAndConditionsController::class, 'ClientStore'])->name('client.terms-conditions.update');

            Route::group(['prefix' => 'site-information', 'as' => 'site-information.'], function () {
                Route::get('/', [SiteInformationSettingsController::class, 'index'])->name('index');
                Route::post('/update', [SiteInformationSettingsController::class, 'update'])->name('update');

            });

        });
        Route::group(['prefix' => 'contact-messages', 'as' => 'contact.'], function () {
            Route::get('/', [ContactMessagesController::class, 'index'])->name('index');
            Route::get('/delete/{id}', [ContactMessagesController::class, 'destroy'])->name('delete');
            Route::get('/show/{id}', [ContactMessagesController::class, 'show'])->name('show');
            Route::post('/replay', [ContactMessagesController::class, 'replayMessage'])->name('replay');

        });
        Route::group(['prefix' => 'advisory-committees', 'as' => 'advisory-committees.'], function () {
            Route::get('/', [AdvisoryCommitteesController::class, 'index'])->name('index');
            Route::get('/delete/{id}', [AdvisoryCommitteesController::class, 'destroy'])->name('delete');
            Route::get('/edit/{id}', [AdvisoryCommitteesController::class, 'edit'])->name('edit');
            Route::post('/update', [AdvisoryCommitteesController::class, 'update'])->name('update');
            Route::post('/store', [AdvisoryCommitteesController::class, 'store'])->name('store');

            Route::group(['prefix' => 'members', 'as' => 'members.'], function () {
                Route::get('/', [AdvisoryCommitteesMembersController::class, 'index'])->name('index');
                Route::get('/delete/{id}', [AdvisoryCommitteesMembersController::class, 'destroy'])->name('delete');
                Route::get('/edit/{id}', [AdvisoryCommitteesMembersController::class, 'edit'])->name('edit');
                Route::post('/update', [AdvisoryCommitteesMembersController::class, 'update'])->name('update');
            });
        });
        Route::group(['prefix' => 'organization-requests', 'as' => 'organization-requests.'], function () {
            Route::get('/', [OrganizationRequestsController::class, 'index'])->name('index');
            Route::post('/update', [OrganizationRequestsController::class, 'update'])->name('update');
            Route::get('/edit/{id}', [OrganizationRequestsController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [OrganizationRequestsController::class, 'destroy'])->name('delete');
            Route::get('/get/data/{id}', [OrganizationRequestsController::class, 'getOrganizationRequestData'])->name('get.data');
            Route::post('/replay', [OrganizationRequestsController::class, 'replay'])->name('replay');

        });
        Route::group(['prefix' => 'request-levels', 'as' => 'request_levels.'], function () {
            Route::get('/', [RequestLevelController::class, 'index'])->name('index');
            Route::post('/store', [RequestLevelController::class, 'store'])->name('store');
            Route::post('/update', [RequestLevelController::class, 'update'])->name('update');
            Route::get('/edit/{id}', [RequestLevelController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [RequestLevelController::class, 'destroy'])->name('delete');
        });
        Route::group(['prefix' => 'services', 'as' => 'services.'], function () {

            Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
                Route::get('/', [ServicesCategoriesController::class, 'index'])->name('index');
                Route::post('/store', [ServicesCategoriesController::class, 'store'])->name('store');
                Route::post('/update', [ServicesCategoriesController::class, 'update'])->name('update');
                Route::get('/edit/{id}', [ServicesCategoriesController::class, 'edit'])->name('edit');
                Route::get('/delete/{id}', [ServicesCategoriesController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => 'sub-categories', 'as' => 'sub_categories.'], function () {
                Route::get('/', [ServicesSubCategoriesController::class, 'index'])->name('index');
                Route::post('/store', [ServicesSubCategoriesController::class, 'store'])->name('store');
                Route::post('/update', [ServicesSubCategoriesController::class, 'update'])->name('update');
                Route::get('/edit/{id}', [ServicesSubCategoriesController::class, 'edit'])->name('edit');
                Route::get('/delete/{id}', [ServicesSubCategoriesController::class, 'destroy'])->name('delete');
                Route::get('get-sub-categories-category-id/{id?}', [ServicesSubCategoriesController::class, 'getSubCategoriesBaseCategoryId'])->name('get-sub-categories-category-id');

            });

            Route::get('/', [ServicesController::class, 'index'])->name('index');
            Route::get('/create', [ServicesController::class, 'create'])->name('create');
            Route::post('/store', [ServicesController::class, 'store'])->name('store');
            Route::post('/update', [ServicesController::class, 'update'])->name('update');
            Route::get('/edit/{id}', [ServicesController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [ServicesController::class, 'destroy'])->name('delete');

            Route::get('/edit/level/{id}', [ServicesController::class, 'editLevel'])->name('level.edit');
            Route::post('/update/level', [ServicesController::class, 'UpdateLevel'])->name('level.update');
            Route::get('/delete/level/{id}', [ServicesController::class, 'DeleteLevel'])->name('level.delete');

        });
        Route::group(['prefix' => 'services-type', 'as' => 'services-type.'], function () {
            Route::get('/', [ServicesController::class, 'index'])->name('index');
        });
        Route::group(['prefix' => 'ymtaz-contacts', 'as' => 'ymtaz-contacts.'], function () {
            Route::get('/', [YmtazContactMessagesController::class, 'index'])->name('index');
            Route::get('/show/{id}', [YmtazContactMessagesController::class, 'show'])->name('show');
            Route::post('/replay', [YmtazContactMessagesController::class, 'replay'])->name('replay');
            Route::get('/delete/{id}', [YmtazContactMessagesController::class, 'destroy'])->name('delete');

        });
        Route::group(['prefix' => 'lawyers', 'as' => "lawyers."], function () {
            Route::group(['prefix' => 'service-request', 'as' => 'service-request.'], function () {
                Route::post('final-replay', [ServiceRequestController::class, 'SendFinalReplayLawyer'])->name('SendFinalReplay');
                Route::post('final-replay/forLawyer', [ServiceRequestController::class, 'SendFinalReplayForLawyerFromLawyer'])->name('SendFinalReplay');
            });
        });
        Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
            Route::get('/', [ClientController::class, 'index'])->name('index');
            Route::get('/export', [ClientController::class, 'ExportUsers'])->name('export-users');
            Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit');
            Route::get('/delete/{id}', [ClientController::class, 'destroy'])->name('destroy');
            Route::post('/update', [ClientController::class, 'update'])->name('update');
            Route::post('/send-email', [ClientController::class, 'SendEmail'])->name('send-email');

            Route::get('get-regions-bade-country-id/{id?}', [ClientController::class, 'getRegionsBaseCountryId'])->name('get-regions-bade-country-id');
            Route::get('get-cities-bade-region-id/{id?}', [ClientController::class, 'getCitiesBaseRegionId'])->name('get-cities-bade-region-id');

            Route::group(['prefix' => 'service-request', 'as' => 'service-request.'], function () {
                Route::get('/', [ServiceRequestController::class, 'index'])->name('index');
                Route::get('/show/{id}', [ServiceRequestController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [ServiceRequestController::class, 'edit'])->name('edit');
                Route::get('/replay/{id}', [ServiceRequestController::class, 'replay'])->name('replay');
                Route::post('/replay', [ServiceRequestController::class, 'replayClientServiceRequest'])->name('replayClientServiceRequest');
                Route::get('/delete/{id}', [ServiceRequestController::class, 'destroy'])->name('delete');
                Route::post('update', [ServiceRequestController::class, 'update'])->name('update');
                Route::get('get-lawyers-base-advisory-id/{adv_id?}/{item_id?}', [ServiceRequestController::class, 'getLawyersBaseAdvisoryId'])->name('get-lawyers-base-advisory-id');
                Route::post('final-replay', [ServiceRequestController::class, 'SendFinalReplay'])->name('SendFinalReplay');
                Route::post('final-replay/forLawyer', [ServiceRequestController::class, 'SendFinalReplayForClientFromLawyer'])->name('SendFinalReplay');
            });
            Route::group(['prefix' => 'ymtaz-contacts', 'as' => 'ymtaz-contacts.'], function () {
                Route::get('/', [YmtazContactsController::class, 'index'])->name('index');
                Route::get('/show/{id}', [YmtazContactsController::class, 'show'])->name('show');
                Route::post('/replay', [YmtazContactsController::class, 'replay'])->name('replay');
                Route::get('/delete/{id}', [YmtazContactsController::class, 'destroy'])->name('delete');
            });
            Route::group(['prefix' => 'lawyer-reservation', 'as' => 'lawyer-reservation.'], function () {
                Route::get('/', [ClientLawyerReservationsAdminController::class, 'index'])->name('index');
                Route::get('/show/{id}', [ClientLawyerReservationsAdminController::class, 'show'])->name('show');
                Route::get('/delete/{id}', [ClientLawyerReservationsAdminController::class, 'destroy'])->name('delete');
            });

            Route::group(['prefix' => 'delete-accounts-requests', 'as' => 'delete-accounts-requests.'], function () {
                Route::get('/', [DeleteAccountRequestController::class, 'index'])->name('index');
                Route::get('show/{id}', [DeleteAccountRequestController::class, 'show'])->name('show');
                Route::get('edit/{id}', [DeleteAccountRequestController::class, 'edit'])->name('edit');
                Route::post('/update', [DeleteAccountRequestController::class, 'update'])->name('update');
                Route::get('delete/{id}', [DeleteAccountRequestController::class, 'destroy'])->name('delete');
            });

        });
        Route::group(['prefix' => 'library', 'as' => 'library.'], function () {
            Route::group(['prefix' => 'category', 'as' => 'category.'], function () {
                Route::get('/', [LibraryCategoryController::class, 'index'])->name('index');
                Route::get('edit/{id}', [LibraryCategoryController::class, 'edit'])->name('edit');
                Route::get('create', [LibraryCategoryController::class, 'create'])->name('create');
                Route::post('update', [LibraryCategoryController::class, 'update'])->name('update');
                Route::get('delete/{id}', [LibraryCategoryController::class, 'destroy'])->name('delete');
                Route::post('store', [LibraryCategoryController::class, 'store'])->name('store');
                Route::group(['prefix' => 'sub-category', 'as' => 'sub-category.'], function () {
                    Route::get('edit/{id}', [LibraryCategoryController::class, 'SubEdit'])->name('edit');
                    Route::post('update', [LibraryCategoryController::class, 'SubUpdate'])->name('update');
                    Route::get('delete/{id}', [LibraryCategoryController::class, 'SubDestroy'])->name('delete');
                });
            });
            Route::group(['prefix' => 'books', 'as' => 'books.'], function () {
                Route::get('/', [BooksLibraryController::class, 'index'])->name('index');
                Route::get('edit/{id}', [BooksLibraryController::class, 'edit'])->name('edit');
                Route::post('update', [BooksLibraryController::class, 'update'])->name('update');
                Route::get('delete/{id}', [BooksLibraryController::class, 'destroy'])->name('delete');
                Route::post('store', [BooksLibraryController::class, 'store'])->name('store');
                Route::get('create', [BooksLibraryController::class, 'create'])->name('create');
                Route::get('get-library-sub-cat-base-id/{id?}', [BooksLibraryController::class, 'getLibrarySubCatBaseId'])->name('get-library-sub-cat-base-id');
            });

            Route::group(['prefix' => 'rules-regulations', 'as' => 'rules_regulations.'], function () {
                Route::get('/', [RulesAndRegulationsController::class, 'index'])->name('index');
                Route::get('edit/{id}', [RulesAndRegulationsController::class, 'edit'])->name('edit');
                Route::post('update', [RulesAndRegulationsController::class, 'update'])->name('update');
                Route::get('delete/{id}', [RulesAndRegulationsController::class, 'destroy'])->name('delete');
                Route::get('/delete/tool/{id}', [RulesAndRegulationsController::class, 'DestroyReleaseTools'])->name('delete.release.tool');
                Route::post('store', [RulesAndRegulationsController::class, 'store'])->name('store');
                Route::get('create', [RulesAndRegulationsController::class, 'create'])->name('create');
                Route::get('get-library-sub-cat-base-id/{id?}', [RulesAndRegulationsController::class, 'getLibrarySubCatBaseId'])->name('get-library-sub-cat-base-id');

            });

            Route::group(['prefix' => 'judicial-blogs', 'as' => 'judicial_blogs.'], function () {
                Route::get('/', [JudicialBlogsController::class, 'index'])->name('index');
                Route::get('edit/{id}', [JudicialBlogsController::class, 'edit'])->name('edit');
                Route::post('update', [JudicialBlogsController::class, 'update'])->name('update');
                Route::get('delete/{id}', [JudicialBlogsController::class, 'destroy'])->name('delete');
                Route::get('/delete/tool/{id}', [JudicialBlogsController::class, 'DestroyReleaseTools'])->name('delete.release.tool');

                Route::post('store', [JudicialBlogsController::class, 'store'])->name('store');
                Route::get('create', [JudicialBlogsController::class, 'create'])->name('create');
                Route::get('get-library-sub-cat-base-id/{id?}', [BooksLibraryController::class, 'getLibrarySubCatBaseId'])->name('get-library-sub-cat-base-id');

            });


        });
        Route::group(['prefix' => 'accurate-specialty', 'as' => 'accurate_specialty.'], function () {
            Route::get('/', [AccurateSpecialtyController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AccurateSpecialtyController::class, 'edit'])->name('edit');
            Route::post('update', [AccurateSpecialtyController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AccurateSpecialtyController::class, 'destroy'])->name('delete');
            Route::post('store', [AccurateSpecialtyController::class, 'store'])->name('store');
            Route::get('create', [AccurateSpecialtyController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'general-specialty', 'as' => 'general_specialty.'], function () {
            Route::get('/', [GeneralSpecialtyController::class, 'index'])->name('index');
            Route::get('edit/{id}', [GeneralSpecialtyController::class, 'edit'])->name('edit');
            Route::post('update', [GeneralSpecialtyController::class, 'update'])->name('update');
            Route::get('delete/{id}', [GeneralSpecialtyController::class, 'destroy'])->name('delete');
            Route::post('store', [GeneralSpecialtyController::class, 'store'])->name('store');
            Route::get('create', [GeneralSpecialtyController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'functional-cases', 'as' => 'functional_cases.'], function () {
            Route::get('/', [FunctionalCasesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [FunctionalCasesController::class, 'edit'])->name('edit');
            Route::post('update', [FunctionalCasesController::class, 'update'])->name('update');
            Route::get('delete/{id}', [FunctionalCasesController::class, 'destroy'])->name('delete');
            Route::post('store', [FunctionalCasesController::class, 'store'])->name('store');
            Route::get('create', [FunctionalCasesController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'advisory-services', 'as' => 'advisory_services.'], function () {
            Route::get('/', [AdvisoryServicesController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdvisoryServicesController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [AdvisoryServicesController::class, 'edit'])->name('show');
            Route::get('get-data/{id?}', [AdvisoryServicesController::class, 'getAdvisoryServices'])->name('get-data');
            Route::post('update', [AdvisoryServicesController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdvisoryServicesController::class, 'destroy'])->name('delete');
            Route::post('store', [AdvisoryServicesController::class, 'store'])->name('store');
            Route::get('create', [AdvisoryServicesController::class, 'create'])->name('create');
            Route::group(['prefix' => 'payment-categories', 'as' => 'payment_categories.'], function () {
                Route::get('/', [AdvisoryServicesPaymentCategoriesController::class, 'index'])->name('index');
                Route::get('edit/{id}', [AdvisoryServicesPaymentCategoriesController::class, 'edit'])->name('edit');
                Route::get('show/{id}', [AdvisoryServicesPaymentCategoriesController::class, 'edit'])->name('show');
                Route::post('update', [AdvisoryServicesPaymentCategoriesController::class, 'update'])->name('update');
                Route::get('delete/{id}', [AdvisoryServicesPaymentCategoriesController::class, 'destroy'])->name('delete');
                Route::post('store', [AdvisoryServicesPaymentCategoriesController::class, 'store'])->name('store');
                Route::get('create', [AdvisoryServicesPaymentCategoriesController::class, 'create'])->name('create');
            });
        });
        Route::group(['prefix' => "advisory-services-base", 'as' => "advisory_services_base."], function () {
            Route::get('/', [AdvisoryServicesBaseController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdvisoryServicesBaseController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [AdvisoryServicesBaseController::class, 'edit'])->name('show');
            Route::post('update', [AdvisoryServicesBaseController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdvisoryServicesBaseController::class, 'destroy'])->name('delete');
            Route::post('store', [AdvisoryServicesBaseController::class, 'store'])->name('store');
            Route::get('create', [AdvisoryServicesBaseController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'advisory-services-types', 'as' => 'advisory_services_types.'], function () {
            Route::get('/', [AdvisoryServicesTypeController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdvisoryServicesTypeController::class, 'edit'])->name('edit');
            Route::post('update', [AdvisoryServicesTypeController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdvisoryServicesTypeController::class, 'destroy'])->name('delete');
            Route::post('store', [AdvisoryServicesTypeController::class, 'store'])->name('store');
            Route::get('create', [AdvisoryServicesTypeController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'advisory-services-importance', 'as' => 'advisory_services_importance.'], function () {
            Route::get('/', [AdvisoryServicesImportanceController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdvisoryServicesImportanceController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [AdvisoryServicesImportanceController::class, 'edit'])->name('show');
            Route::post('update', [AdvisoryServicesImportanceController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdvisoryServicesImportanceController::class, 'destroy'])->name('delete');
            Route::post('store', [AdvisoryServicesImportanceController::class, 'store'])->name('store');
            Route::get('create', [AdvisoryServicesImportanceController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'client-advisory-services-reservations', 'as' => 'client_advisory_services_reservations.'], function () {
            Route::get('/', [AdvisoryServicesReservationsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdvisoryServicesReservationsController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [AdvisoryServicesReservationsController::class, 'edit'])->name('show');
            Route::post('update', [AdvisoryServicesReservationsController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdvisoryServicesReservationsController::class, 'destroy'])->name('delete');
            Route::post('store', [AdvisoryServicesReservationsController::class, 'store'])->name('store');
            Route::get('create', [AdvisoryServicesReservationsController::class, 'create'])->name('create');
            Route::get('/get/data/{id}', [AdvisoryServicesReservationsController::class, 'getClientAdvServicesResData'])->name('get.data');
            Route::post('/replay', [AdvisoryServicesReservationsController::class, 'replay'])->name('replay');
        });
        Route::group(['prefix' => 'client-reservations-types', 'as' => 'client_reservations_types.'], function () {
            Route::get('/', [ClientReservationsTypeController::class, 'index'])->name('index');
            Route::get('edit/{id}', [ClientReservationsTypeController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [ClientReservationsTypeController::class, 'edit'])->name('show');
            Route::post('update', [ClientReservationsTypeController::class, 'update'])->name('update');
            Route::get('delete/{id}', [ClientReservationsTypeController::class, 'destroy'])->name('delete');
            Route::post('store', [ClientReservationsTypeController::class, 'store'])->name('store');
            Route::get('create', [ClientReservationsTypeController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'client-reservations', 'as' => 'client_reservations.'], function () {
            Route::get('/', [ClientReservationsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [ClientReservationsController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [ClientReservationsController::class, 'edit'])->name('show');
            Route::post('update', [ClientReservationsController::class, 'update'])->name('update');
            Route::get('delete/{id}', [ClientReservationsController::class, 'destroy'])->name('delete');
            Route::post('store', [ClientReservationsController::class, 'store'])->name('store');
            Route::get('create', [ClientReservationsController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'client-ymtaz-reservations', 'as' => 'client_ymtaz_reservations.'], function () {
            Route::get('/', [ClientYmtazReservationsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [ClientYmtazReservationsController::class, 'edit'])->name('edit');
            Route::get('show/{id}', [ClientYmtazReservationsController::class, 'show'])->name('show');
            Route::post('update', [ClientYmtazReservationsController::class, 'update'])->name('update');
            Route::get('delete/{id}', [ClientYmtazReservationsController::class, 'destroy'])->name('delete');
            Route::post('store', [ClientYmtazReservationsController::class, 'store'])->name('store');
            Route::get('create', [ClientYmtazReservationsController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'splash', 'as' => 'splash.'], function () {
            Route::get('/', [SplashSettingsController::class, 'index'])->name('index');
            Route::get('edit/{id}', [SplashSettingsController::class, 'edit'])->name('edit');
            Route::post('update', [SplashSettingsController::class, 'update'])->name('update');
            Route::get('delete/{id}', [SplashSettingsController::class, 'destroy'])->name('delete');
            Route::post('store', [SplashSettingsController::class, 'store'])->name('store');
        });
        Route::group(['prefix' => 'complains', 'as' => 'complains.'], function () {
            Route::get('/', [AdminComplaintsController::class, 'index'])->name('index');
            Route::post('/store', [AdminComplaintsController::class, 'store'])->name('store');
            Route::get('delete/{id}', [AdminComplaintsController::class, 'destroy'])->name('delete');
            Route::get('show/{id}', [AdminComplaintsController::class, 'show'])->name('show');


        });
        Route::group(['prefix' => 'training', 'as' => 'training.'], function () {
            Route::get('/', [AdminTrainingController::class, 'index'])->name('index');
            Route::get('edit/{id}', [AdminTrainingController::class, 'edit'])->name('edit');
            Route::post('update', [AdminTrainingController::class, 'update'])->name('update');
            Route::get('delete/{id}', [AdminTrainingController::class, 'destroy'])->name('delete');
            Route::post('store', [AdminTrainingController::class, 'store'])->name('store');
            Route::get('create', [AdminTrainingController::class, 'create'])->name('create');
        });
        Route::group(['prefix' => 'benefit', 'as' => 'benefit.'], function () {
            Route::get('/', [TodayBenefitController::class, 'index'])->name('index');
            Route::get('edit/{id}', [TodayBenefitController::class, 'edit'])->name('edit');
            Route::post('update', [TodayBenefitController::class, 'update'])->name('update');
            Route::get('delete/{id}', [TodayBenefitController::class, 'destroy'])->name('delete');
            Route::post('store', [TodayBenefitController::class, 'store'])->name('store');
        });
    });

    //    Route::get('/test-code', function () {
//        $items = ServiceUser::get();
//        foreach ($items as $item) {
//            $code = substr($item->mobil, 0, 1);
//            if ($code === '0') {
//                $item->update([
//                    'mobil' => ltrim($item->mobil, '0'),
//                    'phone_code' => 966,
//                ]);
//            }
//            $code_966 = substr($item->mobil, 0, 3);
//            if ($code_966 === '966') {
//                $item->update([
//                    'mobil' => ltrim($item->mobil, '966'),
//                    'phone_code' => 966,
//                ]);
//            }
//
//        }
//        dd('تمت العملية بنجاح');
//    });

});
