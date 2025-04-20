<?php

namespace App\Http\Controllers\Admin\Settings\Regions;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $regions = Regions::where('status', 1)->with('country')->orderBy('created_at', 'desc')->get();
            return DataTables::of($regions)
                ->addColumn('country', function ($row) {
                    return $row->country->name;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-regions m-1"  id="btn_delete_regions_' . $row->id . '"  href="' . route('admin.regions.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_regions"  href="' . route('admin.regions.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('admin.settings.regions.index', compact('countries'));

    }


    public function newIndex()
    {
        $regions = Regions::where('status', 1)->orderBy('created_at', 'desc')->get();
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Regions/index', get_defined_vars());

    }
    public function newEdit($id)
    {
        $region = Regions::where('status', 1)->orderBy('created_at', 'desc')->findOrFail($id);
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Regions/Edit/index', get_defined_vars());

    }

    public function newCreate()
    {
        $countries = Country::where('status', 1)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Settings/Signup/Regions/Create/index', get_defined_vars());
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
            '*' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $item = Regions::create([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);
        return to_route('newAdmin.settings.signup.regions.edit', ["id" => $item->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $region = Regions::findOrFail($id);
        return \response()->json([
            'status' => true,
            'region' => $region
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
        $region = Regions::findOrFail($request->id);
        $region->update([
            'name' => $request->name,
            'country_id' => $request->country_id
        ]);
        return \response()->json([
            'status' => true,
            'region' => $region
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

        $region = Regions::findOrFail($id);
        $region->status = 0;
        $region->update();
        return to_route('newAdmin.settings.signup.regions.index');
    }
}
