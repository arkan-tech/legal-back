<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Models\PaymentCategoryType;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Requests\Admin\AdvisoryServices\CreateAdvisoryServicesRequest;

class AdvisoryServicesPaymentCategoryTypesController extends Controller
{

    public function index(Request $request)
    {
        $paymentCategoriesTypes = PaymentCategoryType::get();

        return Inertia::render('Settings/AdvisoryServices/PaymentCategoriesTypes/index', get_defined_vars());

    }
    public function edit($id)
    {
        $paymentCategoriesType = PaymentCategoryType::findOrFail($id);

        return Inertia::render('Settings/AdvisoryServices/PaymentCategoriesTypes/Edit/index', get_defined_vars());
    }

    public function create()
    {

        return Inertia::render('Settings/AdvisoryServices/PaymentCategoriesTypes/Create/index', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'sometimes',
            'requires_appointment' => 'sometimes'
        ], [
            'name.required' => 'اسم الوسيلة مطلوب',
        ]);

        $PaymentCategoryType = PaymentCategoryType::create([
            'name' => $request->name,
            'description' => $request->description,
            'requires_appointment' => !is_null($request->requires_appointment) ? $request->requires_appointment : false,
        ]);

        return to_route('newAdmin.settings.advisory_services.payment-categories-types.edit', ["id" => $PaymentCategoryType->id]);
    }


    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'sometimes',
            'requires_appointment' => 'sometimes'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = PaymentCategoryType::findOrFail($request->id);
        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'requires_appointment' => !is_null($request->requires_appointment) ? $request->requires_appointment : false,
        ]);
        return \response()->json([
            'status' => true,
        ]);

    }


}
