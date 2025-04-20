<?php

namespace App\Http\Controllers\NewAdmin;

use Inertia\Inertia;
use App\Models\Books;
use App\Models\Activity;
use App\Models\City\City;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use App\Models\Service\Service;
use App\Models\BooksSubCategories;
use App\Models\BooksMainCategories;
use App\Models\PaymentCategoryType;
use App\Http\Controllers\Controller;
use App\Rules\ArrayAtLeastOneRequired;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSubCategory;
use App\Models\Reservations\ReservationType;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use Google\Service\AndroidEnterprise\GoogleAuthenticationSettings;


class ProductsController extends Controller
{
    public function index()
    {
        $services = Service::with('category', 'ymtaz_levels_prices.level')->orderBy('created_at', 'desc')->get();
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();

        $subCategories = AdvisoryServicesSubCategory::with([
            'prices' =>
                function ($query) {
                    $query->whereNull('lawyer_id')->with('importance');
                },
            'generalCategory'
        ])->get();
        $advisoryServices = AdvisoryServices::get();
        $reservationTypes = ReservationType::with([
            'typesImportance' => function ($query) {
                $query->where('isYmtaz', 1)->with(['reservationType', 'reservationImportance']);
            }
        ])->get();
        return Inertia::render('Settings/Products/index', get_defined_vars());
    }

    public function indexServices()
    {
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $services = Service::with('category', 'ymtaz_levels_prices.level')->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Products/Services/index', get_defined_vars());
    }


    public function advisoryServices()
    {

        $generalCategories = AdvisoryServicesGeneralCategory::with('paymentCategoryType')->get();

        $paymentCategoriesTypes = PaymentCategoryType::get();
        $subCategories = AdvisoryServicesSubCategory::with([
            'prices' =>
                function ($query) {
                    $query->whereNull('lawyer_id')->with('importance');
                },
            'generalCategory'
        ])->get();

        return Inertia::render('Settings/Products/AdvisoryServices/index', get_defined_vars());
    }


}
