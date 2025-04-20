<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\AdvisoryServicesPrices;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;

class AdvisoryServicesTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AdvisoryServicesTypes::orderBy('created_at', 'desc')->with('advisoryService')->get();
            return DataTables::of($items)
                ->addColumn('advisory_service', function ($row) {
                    return $row->advisoryService->title;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-services-types m-1"  id="btn_delete_advisory_services_types_' . $row->id . '"  href="' . route('admin.advisory_services_types.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_advisory_services_types"  href="' . route('admin.advisory_services_types.edit', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.advisory_services.types.index');

    }

    public function newIndex(Request $request)
    {
        $types = AdvisoryServicesTypes::orderBy('created_at', 'desc')->with(['advisoryService', 'advisoryService.payment_category', 'advisoryService.payment_category_type', 'advisoryService.payment_category.advisory_services_base'])->get();
        $advisoryServices = AdvisoryServices::get();
        return Inertia::render('Settings/AdvisoryServices/Types/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $type = AdvisoryServicesTypes::orderBy('created_at', 'desc')->with([
            'advisory_services_prices.importance',
            'lawyerSections',
            'advisory_services_prices' => function ($query) {
                $query->where('is_ymtaz', 1);
            },
            'advisoryService.payment_category',
            'advisoryService.payment_category.advisory_services_base',
        ])->findOrFail($id);
        $advisoryServices = AdvisoryServices::with(['payment_category_type'])->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $baseCategories = AdvisoryServicesBase::get();
        $paymentCategories = AdvisoryServicesPaymentCategory::get();
        return Inertia::render('Settings/AdvisoryServices/Types/Edit/index', get_defined_vars());
    }

    public function newCreate(Request $request)
    {
        $advisoryServices = AdvisoryServices::with(['payment_category_type'])->get();
        $importance = ClientReservationsImportance::where('status', 1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $baseCategories = AdvisoryServicesBase::get();
        $paymentCategories = AdvisoryServicesPaymentCategory::get();
        return Inertia::render('Settings/AdvisoryServices/Types/Create/index', get_defined_vars());

    }
    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
        // $advisory_services = AdvisoryServices::get();
        // return \response()->json([
        //     'status' => true,
        // 	'advisory_services'=>$advisory_services
        // ]);
        return Inertia::render('Settings/AdvisoryServices/Types/Create/index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {

        $request->validate([
            '*' => 'required',
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric',
            'importance' => 'required|array',
            'importance.*.price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value < $request->input('min_price') || $value > $request->input('max_price')) {
                        $fail("السعر يجب ان يكون بين الحد الأدنى و الأقصى");
                    }
                }
            ]
        ], [
            '*.required' => 'الحقل مطلوب',
            'min_price.required' => 'الحقل مطلوب',
            'max_price.required' => 'الحقل مطلوب',
            'importance.required' => 'الحقل مطلوب',
        ]);

        $item = AdvisoryServicesTypes::create([
            'title' => $request->name,
            'advisory_service_id' => $request->advisory_service,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
        ]);

        AdvisoryServicesPrices::where('is_ymtaz', 1)
            ->where('advisory_service_id', $item->id)
            ->delete();
        foreach ($request->importance as $req) {
            if ($item->min_price > intval($req['price']) || intval($req['price']) > $item->max_price) {
                return \response()->json([
                    'status' => false,
                    'errors' => [
                        'importance' => 'Price is not between min and max price'
                    ]
                ], 422);
            }
            $importance = ClientReservationsImportance::findOrFail($req['id']);
            $newServicePricing = new AdvisoryServicesPrices();
            $newServicePricing->is_ymtaz = 1;
            $newServicePricing->advisory_service_id = $item->id;
            $newServicePricing->client_reservations_importance_id = $importance->id;
            $newServicePricing->price = intval($req['price']);
            $newServicePricing->is_ymtaz = true;
            $newServicePricing->save();
        }
        foreach ($request->section_id as $section) {
            $item->lawyerSections()->attach(
                $section,
            );
        }
        return to_route("newAdmin.settings.advisory_services.types.edit", ["id" => $item->id]);
    }

    public function getAdvisoryServices()
    {
        $advisory_services = AdvisoryServices::get();
        return response()->json($advisory_services);
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
        $item = AdvisoryServicesTypes::where('id', $id)->with('advisoryService')->first();
        $advisory_services = AdvisoryServices::get();
        return \response()->json([
            'status' => true,
            'item' => $item,
            'advisory_services' => $advisory_services
        ]);
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
        $item = AdvisoryServicesTypes::with('lawyerSections')->findOrFail($request->id);
        $item->update([
            'title' => $request->name,
            'advisory_service_id' => $request->advisory_service,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price
        ]);
        AdvisoryServicesPrices::where('is_ymtaz', 1)
            ->where('advisory_service_id', $item->id)
            ->delete();
        foreach ($request->importance as $req) {
            if ($item->min_price > intval($req['price']) || intval($req['price']) > $item->max_price) {
                return \response()->json([
                    'status' => false,
                    'errors' => [
                        'prices' => 'Price is not between min and max price'
                    ]
                ], 422);
            }
            $importance = ClientReservationsImportance::findOrFail($req['id']);
            $newServicePricing = new AdvisoryServicesPrices();
            $newServicePricing->is_ymtaz = 1;
            $newServicePricing->advisory_service_id = $item->id;
            $newServicePricing->client_reservations_importance_id = $importance->id;
            $newServicePricing->price = intval($req['price']);
            $newServicePricing->is_ymtaz = true;
            $newServicePricing->save();
        }

        $item->lawyerSections()->detach();

        foreach ($request->section_id as $section) {
            $item->lawyerSections()->attach(
                $section,
            );
        }

        return \response()->json([
            'status' => true,
        ]);

    }

    public function toggle(Request $request, $id)
    {
        $type = AdvisoryServicesTypes::findOrFail($id);
        $type->isHidden = !$request->enabled;
        $type->save();

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = AdvisoryServicesTypes::findOrFail($id);
        $item->delete();
        return \response()->json([
            'status' => true,
        ]);
    }
}
