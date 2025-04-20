<?php

namespace App\Http\Controllers\Admin\Packages;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Package\Package;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\DigitalGuide\DigitalGuidePackage;
use App\Http\Requests\Admin\DigitalGuide\Packages\StorePackagesRequest;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $packages = DigitalGuidePackage::where('status', 1)->orderBy('created_at', 'desc')->get();
            return DataTables::of($packages)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-digital-guide-package m-1"  id="btn_delete_digital_guide_package_' . $row->id . '"  href="' . route('admin.digital-guide.packages.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"    href="' . route('admin.digital-guide.packages.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.digital_guide.packages.index');
    }

    public function newIndex()
    {
        $packages = DigitalGuidePackage::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Packages/index', get_defined_vars());
    }
    public function newEdit($id)
    {
        $packageDetails = DigitalGuidePackage::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        $success = session('success', false);
        return Inertia::render('Packages/Edit/index', get_defined_vars());
    }
    public function newCreate()
    {
        return Inertia::render('Packages/Create/index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.digital_guide.packages.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(StorePackagesRequest $request)
    {
        $item = DigitalGuidePackage::create($request->except('_token'));
        return to_route('newAdmin.packages.edit', ['id' => $item->id]);
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
        $package = DigitalGuidePackage::findOrFail($id);
        return view('admin.digital_guide.packages.edit', compact('package'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(StorePackagesRequest $request)
    {
        $package = DigitalGuidePackage::findOrFail($request->id);
        $package->update($request->except('_token', 'id'));
        return response()->json([
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
        $package = DigitalGuidePackage::findOrFail($id);
        $package->update(['status' => 0]);
        $package->delete();
        return to_route('newAdmin.packages.index');
    }
}
