<?php

namespace App\Http\Controllers\Admin\Settings\Districts;

use App\Http\Controllers\Controller;
use App\Models\City\City;
use App\Models\Country\Country;
use App\Models\Districts\Districts;
use App\Models\Regions\Regions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use function response;

class DistrictsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $districts = Districts::where('status', 1)->with('City', 'region', 'country')->orderBy('created_at', 'desc')->get();
            return DataTables::of($districts)
                ->addColumn('country', function ($row) {
                    return $row->country->name;
                })
                ->addColumn('region', function ($row) {
                    return $row->region->name;
                })
                ->addColumn('city', function ($row) {
                    return $row->City->title;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-cities m-1"  id="btn_delete_cities_' . $row->id . '"  href="' . route('admin.districts.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn_edit_districts"  href="' . route('admin.districts.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Country::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        return view('admin.settings.districts.index', get_defined_vars());

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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        Districts::create([
            'title' => $request->name,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
        ]);
        return response()->json([
            'status' => true
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
        $district = Districts::findOrFail($id);
        return response()->json([
            'status' => true,
            'district' => $district
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
            '*' => 'required'
        ], [
            '*.required' => 'الحقل مطلوب'
        ]);
        $city = Districts::findOrFail($request->id);
        $city->update([
            'title' => $request->name,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
        ]);
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
        $city = Districts::findOrFail($id);
        $city->status = 0;
        $city->update();
        return response()->json([
            'status' => true,
        ]);
    }
}
