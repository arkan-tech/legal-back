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
use App\Models\AdvisoryServices\AdvisoryServicesSubCategory;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDates;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesGeneralCategory;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;
use App\Models\AdvisoryServices\AdvisoryServicesAvailableDatesTimes;
use App\Http\Requests\Admin\AdvisoryServices\CreateAdvisoryServicesRequest;

class AdvisoryServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AdvisoryServices::orderBy('created_at', 'desc')->with(['payment_category.advisory_services_base', 'payment_category_type'])->get();
            return DataTables::of($items)
                ->addColumn('payment_category', function ($row) {
                    $payment_category = $row->payment_category->name;
                    return $payment_category;
                })
                ->addColumn('min_price', function ($row) {
                    return $row->min_price;
                })
                ->addColumn('max_price', function ($row) {
                    return $row->max_price;
                })
                ->addColumn('ymtaz_price', function ($row) {
                    return $row->ymtaz_price;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-services m-1"  id="btn_delete_advisory_services_' . $row->id . '"  href="' . route('admin.advisory_services.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class=" m-1"    href="' . route('admin.advisory_services.edit', $row->id) . '"  title="تعديل ">
                                      <i class="fa fa-user-edit"></i>
                                  </a>
                                  ';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.advisory_services.index');

    }

    public function newIndex(Request $request)
    {
        $advisoryServices = AdvisoryServices::orderBy('created_at', 'desc')->with(['payment_category.advisory_services_base', 'payment_category_type'])->get();
        $paymentCategories = AdvisoryServicesPaymentCategory::get();
        return Inertia::render('Settings/AdvisoryServices/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $advisoryService = AdvisoryServices::with(['payment_category.advisory_services_base', 'payment_category_type'])->findOrFail($id);
        $paymentCategories = AdvisoryServicesPaymentCategory::get();
        $baseCategories = AdvisoryServicesBase::get();
        $paymentCategoriesTypes = PaymentCategoryType::get();
        return Inertia::render('Settings/AdvisoryServices/Edit/index', get_defined_vars());
    }

    public function newCreate()
    {
        $paymentCategories = AdvisoryServicesPaymentCategory::get();
        $baseCategories = AdvisoryServicesBase::get();
        $paymentCategoriesTypes = PaymentCategoryType::get();
        return Inertia::render('Settings/AdvisoryServices/Create/index', get_defined_vars());

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $payment_methods = AdvisoryServicesPaymentCategory::where('status', 1)->get();
        $request_levels = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.advisory_services.create', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $inputs = $request->all();
        $need_appointment = 0;
        $required = 'sometimes';
        if (array_key_exists('need_appointment', $inputs)) {
            $need_appointment = 1;
            $required = 'required';
        }
        $request->validate([
            'payment_category_type_id' => 'required',
            'description' => 'required',
            'payment_category_id' => 'required',
            'instructions' => 'required'

        ], [
            'payment_category_type_id.required' => 'اسم الخدمة مطلوب',
            'description.required' => 'الوصف القصير مطلوب',
            'payment_category_id.required' => 'قسم الاستشارات مطلوب',
            'instructions.required' => 'التعليمات مطلوبة'
        ]);


        $AdvisoryServices = AdvisoryServices::create([
            'payment_category_type_id' => $request->payment_category_type_id,
            'description' => $request->description,
            'payment_category_id' => $request->payment_category_id,
            'need_appointment' => $request->need_appointment == 'on' ? 1 : 0,
            'instructions' => $request->instructions,
            'image' => ''
        ]);

        return to_route('newAdmin.settings.advisory_services.edit', ["id" => $AdvisoryServices->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $item = AdvisoryServices::with('available_dates.available_times', "advisory_services_prices")->findOrFail($id);
        $payment_methods = AdvisoryServicesPaymentCategory::get();
        $request_levels = $item->advisory_services_prices;
        return view('admin.advisory_services.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {

        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = AdvisoryServices::findOrFail($request->id);
        $item->update([
            'payment_category_type_id' => $request->payment_category_type_id,
            'need_appointment' => $request->need_appointment,
            'payment_category_id' => $request->payment_category_id,
            'description' => $request->description,
            'instructions' => $request->instructions
        ]);
        return \response()->json([
            'status' => true,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $item = AdvisoryServices::findOrFail($id);
        $item->delete();
        return to_route('newAdmin.settings.advisory_services.index');
    }

    public function getAdvisoryServices($id)
    {
        $item = AdvisoryServicesPaymentCategory::findOrFail($id);
        return response()->json([
            'status' => true,
            'item' => $item,
        ]);
    }

    public function generalCategoriesIndex()
    {
        $generalCategories = AdvisoryServicesGeneralCategory::with('paymentCategoryType')->get();
        return Inertia::render('Settings/AdvisoryServices/Main/index', get_defined_vars());
    }

    public function generalCategoriesCreate()
    {
        $paymentCategoryTypes = PaymentCategoryType::get();
        return Inertia::render('Settings/AdvisoryServices/Main/Create/index', get_defined_vars());
    }

    public function generalCategoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_category_type_id' => 'required|exists:advisory_services_payment_categories_types,id',
        ]);

        AdvisoryServicesGeneralCategory::create($request->all());

        return redirect()->route('newAdmin.settings.advisory_services.general-categories.index')->with('success', 'General category created successfully.');
    }

    public function generalCategoriesEdit($id)
    {
        $generalCategory = AdvisoryServicesGeneralCategory::findOrFail($id);
        $paymentCategoryTypes = PaymentCategoryType::all();
        return Inertia::render('Settings/AdvisoryServices/Main/Edit/index', get_defined_vars());
    }

    public function generalCategoriesUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'payment_category_type_id' => 'required|exists:advisory_services_payment_categories_types,id',
        ]);

        $generalCategory = AdvisoryServicesGeneralCategory::findOrFail($id);
        $generalCategory->update($request->all());
        return response()->json([
            'status' => true,
        ]);
    }

    public function generalCategoriesDestroy($id)
    {
        $generalCategory = AdvisoryServicesGeneralCategory::findOrFail($id);
        $generalCategory->delete();

        return redirect()->route('newAdmin.settings.advisory_services.general-categories.index')->with('success', 'General category deleted successfully.');
    }

    public function subCategoriesIndex()
    {
        $subCategories = AdvisoryServicesSubCategory::with([
            'prices' =>
                function ($query) {
                    $query->whereNull('lawyer_id')->with('importance');
                },
            'generalCategory'
        ])->get();
        return Inertia::render('Settings/AdvisoryServices/Sub/index', get_defined_vars());
    }

    public function subCategoriesCreate()
    {
        $generalCategories = AdvisoryServicesGeneralCategory::all();
        $paymentCategoryTypes = PaymentCategoryType::all();
        $importances = ClientReservationsImportance::all();
        return Inertia::render('Settings/AdvisoryServices/Sub/Create/index', get_defined_vars());
    }

    public function subCategoriesStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'general_category_id' => 'required|exists:advisory_services_general_categories,id',
            'prices' => 'required|array',
            'prices.*.duration' => 'required|integer',
            'prices.*.importance_id' => 'required|exists:client_reservations_importance,id',
            'prices.*.price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric|gt:min_price',
        ]);

        $subCategory = AdvisoryServicesSubCategory::create($request->only('name', 'description', 'general_category_id', 'min_price', 'max_price'));

        foreach ($request->prices as $price) {
            $subCategory->prices()->create($price);
        }

        return redirect()->route('newAdmin.settings.advisory_services.sub-categories.index')->with('success', 'Sub-category created successfully.');
    }

    public function subCategoriesEdit($id)
    {
        $subCategory = AdvisoryServicesSubCategory::with([
            'prices' => function ($query) {
                $query->whereNull('lawyer_id');
            }
        ])->with('generalCategory')->findOrFail($id);
        $generalCategories = AdvisoryServicesGeneralCategory::all();
        $paymentCategoryTypes = PaymentCategoryType::all();
        $importances = ClientReservationsImportance::all();
        return Inertia::render('Settings/AdvisoryServices/Sub/Edit/index', get_defined_vars());
    }

    public function subCategoriesUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'general_category_id' => 'required|exists:advisory_services_general_categories,id',
            'prices' => 'required|array',
            'prices.*.duration' => 'required|integer',
            'prices.*.importance_id' => 'required|exists:client_reservations_importance,id',
            'prices.*.price' => 'required|numeric',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric|gt:min_price',
        ]);

        $subCategory = AdvisoryServicesSubCategory::findOrFail($id);
        $subCategory->update($request->only('name', 'description', 'general_category_id', 'min_price', 'max_price'));

        $subCategory->prices()->delete();
        foreach ($request->prices as $price) {
            $subCategory->prices()->create($price);
        }

        return response()->json([
            'status' => true,
        ]);
    }

    public function subCategoriesDestroy($id)
    {
        $subCategory = AdvisoryServicesSubCategory::findOrFail($id);
        $subCategory->delete();
        return response()->json(['message' => 'Sub category deleted successfully']);
    }

    public function toggleSubCategoryVisibility($id)
    {
        $subCategory = AdvisoryServicesSubCategory::findOrFail($id);
        $subCategory->is_hidden = !$subCategory->is_hidden;
        $subCategory->save();

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث حالة الظهور بنجاح',
            'is_hidden' => $subCategory->is_hidden
        ]);
    }
}
