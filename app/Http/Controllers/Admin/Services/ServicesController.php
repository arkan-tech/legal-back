<?php

namespace App\Http\Controllers\Admin\Services;

use App\Http\Controllers\Controller;
use App\Models\ClientReservations\ClientReservationsImportance;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\RequestLevels\RequestLevel;
use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSections;
use App\Models\Service\ServiceSubCategory;
use App\Models\Service\ServiceYmtazLevelPrices;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Yajra\DataTables\DataTables;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = Service::with('category')->where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($services)
                ->addColumn('category', function ($row) {
                    if (!is_null($row->category_id)) {
                        $category = $row->category->name;
                    } else {
                        $category = '-';
                    }
                    return $category;
                })
                ->addColumn('request_level', function ($row) {
                    if (!is_null($row->request_level_id)) {
                        $request_level = $row->request_level->name;
                    } else {
                        $request_level = '-';
                    }
                    return $request_level;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-services m-1"  id="btn_delete_services_' . $row->id . '"  href="' . route('admin.services.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"  href="' . route('admin.services.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $sub_categories = ServiceSubCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $request_levels = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.services.index', get_defined_vars());

    }

    public function newIndex(Request $request)
    {
        $services = Service::with('category', 'ymtaz_levels_prices.level')->orderBy('created_at', 'desc')->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $sub_categories = ServiceSubCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $request_levels = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Services/index', get_defined_vars());

    }
    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $sub_categories = ServiceSubCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $request_levels = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
        // return view('admin.services.create', get_defined_vars());
        return Inertia::render('Settings/Services/Create/index', get_defined_vars());

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
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);

        $service = Service::create([
            'title' => $request->name,
            'intro' => $request->intro,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            // 'ymtaz_price' => $request->ymtaz_price,
            'category_id' => $request->category_id,
            'need_appointment' => $request->need_appointment
        ]);
        // if ($request->has('image')) {
        //     $service->image = saveImage($request->file('image'), 'uploads/services/');
        //     $service->update();
        // }
        $service->section()->sync($request->section_id);
        // foreach ($request->section_id as $section) {
        //     ServiceSections::create([
        //         'service_id' => $service->id,
        //         'section_id' => $section,
        //     ]);
        // }
        foreach ($request->levels as $level) {
            if (!is_null($level['level_id'])) {
                ServiceYmtazLevelPrices::create([
                    'service_id' => $service->id,
                    'request_level_id' => $level['level_id'],
                    'price' => $level['price'],
                    'duration' => $level['duration'],
                ]);
            }
        }
        return to_route('newAdmin.settingsServicesEdit', ["id" => $service->id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        $service = Service::with('ymtaz_levels_prices.level')->findOrFail($id);

        $sections_ids = ServiceSections::where('service_id', $id)->pluck('section_id')->toArray();

        $sections = DigitalGuideCategories::where('status', 1)->get();
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $sub_categories = ServiceSubCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        $request_levels = ClientReservationsImportance::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Services/Edit/index', get_defined_vars());


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
            'image' => 'sometimes',
            'levels' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);

        $service = Service::findOrFail($request->id);
        $service->update([
            'title' => $request->name,
            'intro' => $request->intro,
            'min_price' => $request->min_price,
            'max_price' => $request->max_price,
            // 'ymtaz_price' => $request->ymtaz_price,
            'category_id' => $request->category_id,
            'need_appointment' => $request->need_appointment

        ]);
        // if ($request->has('image')) {
        //     $service->image = saveImage($request->file('image'), 'uploads/services/');
        //     $service->update();
        // }
        $service->section()->sync($request->section_id);

        // $service_sections = ServiceSections::where('service_id', $service->id)->get();
        // foreach ($service_sections as $item) {
        //     $item->delete();
        // }

        // foreach ($request->section_id as $section) {
        //     ServiceSections::create([
        //         'service_id' => $service->id,
        //         'section_id' => $section,
        //     ]);
        // }
        if ($request->has('levels')) {
            $service_prices = ServiceYmtazLevelPrices::where('service_id', $service->id)->get();
            foreach ($service_prices as $item) {
                $item->delete();
            }
            foreach ($request->levels as $level) {
                if (!is_null($level['level_id'])) {
                    ServiceYmtazLevelPrices::create([
                        'service_id' => $service->id,
                        'request_level_id' => $level['level_id'],
                        'price' => $level['price'],
                        'duration' => $level['duration'],
                    ]);
                }
            }
        }
        return \response()->json([
            'status' => true,
        ]);
    }

    public function toggle(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->isHidden = !$request->enabled;
        $service->save();

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
        $item = Service::findOrFail($id);
        $item->delete();
        return to_route('newAdmin.servicesIndex');
    }

    public function editLevel($id)
    {
        $item = ServiceYmtazLevelPrices::findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item
        ]);
    }

    public function UpdateLevel(Request $request)
    {
        $request->validate([
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);

        $item = ServiceYmtazLevelPrices::findOrFail($request->id);
        $item->update([
            'request_level_id' => $request->request_level_id,
            'price' => $request->price,
        ]);
        return \response()->json([
            'status' => true
        ]);
    }

    public function DeleteLevel($id)
    {
        $item = ServiceYmtazLevelPrices::findOrFail($id);
        $item->delete();
        return \response()->json([
            'status' => true
        ]);
    }
}
