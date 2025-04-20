<?php

namespace App\Http\Controllers\Admin\Services\Categories;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Service\Service;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSections;
use App\Models\DigitalGuide\DigitalGuideCategories;

class ServicesCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($services)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-services-categories m-1"  id="btn_delete_services_categories_' . $row->id . '"  href="' . route('admin.services.categories.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_services_categories"  href="' . route('admin.services.categories.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.services.categories.index', get_defined_vars());

    }

    public function newIndex(Request $request)
    {
        $categories = ServiceCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Services/Categories/index', get_defined_vars());
    }

    public function create()
    {
        return Inertia::render('Settings/Services/Categories/Create/index', get_defined_vars());

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
        ], [
            'name.required' => 'الحقل مطلوب',
        ]);

        $newServiceCategory = ServiceCategory::create([
            'name' => $request->name,
            'status' => 1,
        ]);

        return to_route('newAdmin.settingsServicesCategoriesEdit', ["id" => $newServiceCategory->id]);
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
     */
    public function edit($id)
    {
        $category = ServiceCategory::where('status', 1)->findOrFail($id);
        return Inertia::render('Settings/Services/Categories/Edit/index', get_defined_vars());

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
            'name' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
        ]);
        $service = ServiceCategory::findOrFail($request->id);
        $service->update([
            'name' => $request->name,
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
        $item = ServiceCategory::where('status', 1)->findOrFail($id);
        $item->delete();
        return to_route('newAdmin.settingsServicesCategoriesIndex');
    }
}
