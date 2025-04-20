<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\AdvisoryServices\AdvisoryServices;
use App\Models\AdvisoryServices\AdvisoryServicesBase;
use App\Models\AdvisoryServices\AdvisoryServicesTypes;
use App\Models\AdvisoryServices\AdvisoryServicesPaymentCategory;

class AdvisoryServicesPaymentCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $items = AdvisoryServicesPaymentCategory::orderBy('created_at', 'asc')->with('advisory_services_base')->get();
            return DataTables::of($items)
                ->addColumn('base', function ($row) {
                    return $row->advisory_services_base->title;
                })
                ->addColumn('payment_method', function ($row) {
                    $payment_method = $row->payment_method;
                    switch ($payment_method) {
                        case 1:
                            return 'مجانية';
                            break;
                        case 2:
                            return 'مدفوعة';
                            break;
                        case 3:
                            return 'متخصصة';
                            break;
                    }
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-advisory-services-payment-category m-1"  id="btn_delete_advisory_services_payment_category_' . $row->id . '"  href="' . route('admin.advisory_services.payment_categories.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"  href="' . route('admin.advisory_services.payment_categories.edit', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.advisory_services.payment_categories.index');

    }

    public function newIndex(Request $request)
    {
        $advisoryServicesPaymentCategory = AdvisoryServicesPaymentCategory::orderBy('created_at', 'desc')->get();
        $base = AdvisoryServicesBase::get();
        return Inertia::render('Settings/AdvisoryServices/PaymentCategories/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $paymentCategory = AdvisoryServicesPaymentCategory::orderBy('created_at', 'desc')->findOrFail($id);
        $base = AdvisoryServicesBase::get();
        return Inertia::render('Settings/AdvisoryServices/PaymentCategories/Edit/index', get_defined_vars());
    }

    public function newCreate()
    {
        $base = AdvisoryServicesBase::get();

        return Inertia::render('Settings/AdvisoryServices/PaymentCategories/Create/index', get_defined_vars());

    }
    public function create()
    {
        $advisory_services_base = AdvisoryServicesBase::get();
        $base = AdvisoryServicesBase::get();

        return view('admin.advisory_services.payment_categories.create', get_defined_vars());

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
            // 'count' => 'required_if:payment_method,3',
            // 'period' => 'required_if:payment_method,3',
        ], [
            '*.required' => 'الحقل مطلوب',
            // 'count.required_if' => 'الحقل مطلوب',
            // 'period.required_if' => 'الحقل مطلوب',
        ]);
        $advisory_service_base = AdvisoryServicesBase::findOrFail($request->advisory_services_base_id);

        $item = AdvisoryServicesPaymentCategory::create([
            'name' => $request->name,
            'advisory_service_base_id' => $request->advisory_services_base_id,
            'payment_method' => $request->payment_method,
            // 'period' => $request->period,
            // 'count' => $request->count,
            'status' => 1,
        ]);
        return to_route('newAdmin.settings.advisory_services.payment_categories.edit', ['id' => $item->id]);
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
        $item = AdvisoryServicesPaymentCategory::findOrFail($id);
        $advisory_services_base = AdvisoryServicesBase::get();
        return view('admin.advisory_services.payment_categories.edit', get_defined_vars());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request)
    {
        $request->validate([
            '*' => 'required',
            // 'count' => 'required_if:payment_method,3',
            // 'period' => 'required_if:payment_method,3',
        ], [
            '*.required' => 'الحقل مطلوب',
            // 'count.required_if' => 'الحقل مطلوب',
            // 'period.required_if' => 'الحقل مطلوب',
        ]);
        $item = AdvisoryServicesPaymentCategory::findOrFail($request->id);
        $item->update([
            'name' => $request->name,
            'payment_method' => $request->payment_method,
            'advisory_service_base_id' => $request->advisory_service_base_id
            // 'period' => $request->period,
            // 'count' => $request->count,
        ]);
        return to_route('newAdmin.settings.advisory_services.payment_categories.edit', ['id' => $item->id]);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = AdvisoryServicesPaymentCategory::findOrFail($id);
        $item->delete();
        return to_route("newAdmin.settings.advisory_services.payment_categories.index");
    }
}
