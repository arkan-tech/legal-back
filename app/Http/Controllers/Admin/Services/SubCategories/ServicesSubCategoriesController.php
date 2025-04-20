<?php

namespace App\Http\Controllers\Admin\Services\SubCategories;

use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Service\Service;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceSections;
use App\Models\Service\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class ServicesSubCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $services = ServiceSubCategory::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($services)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-services-sub-categories m-1"  id="btn_delete_services_sub_categories_' . $row->id . '"  href="' . route('admin.services.sub_categories.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_services_sub_categories"  href="' . route('admin.services.sub_categories.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $categories = ServiceCategory::where('status',1)->get();
        return view('admin.services.sub_categories.index', get_defined_vars());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
            'category_id.required' => 'الحقل مطلوب',
        ]);

        ServiceSubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'status' => 1,
        ]);

        return response()->json([
            'status' => true,
        ]);
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
        $item = ServiceSubCategory::where('status', 1)->findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item,
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
            'name' => 'required',
            'category_id' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
            'category_id.required' => 'الحقل مطلوب',
        ]);
        $service = ServiceSubCategory::findOrFail($request->id);
        $service->update([
            'category_id' => $request->category_id,
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
     * @return Response
     */
    public function destroy($id)
    {
        $item = ServiceSubCategory::where('status', 1)->findOrFail($id);
        $item->update([
            'status' => 0
        ]);
        return \response()->json([
            'status' => true
        ]);
    }
    public function getSubCategoriesBaseCategoryId($id)
    {
        $items = ServiceSubCategory::where('category_id', $id)->where('status', 1)->get();
        $items_html = view('admin.services.sub-categories-select', compact('items'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);

    }
}
