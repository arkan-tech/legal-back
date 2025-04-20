<?php

namespace App\Http\Controllers\Admin\Settings\SiteInformation;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use App\Models\YmtazSettings\YmtazWorkDays;
use App\Models\YmtazSettings\YmtazWorkDayTimes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function GuzzleHttp\Promise\all;

class SiteInformationSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $settings = Setting::where('group', 'site')->get();
//        $times =
        return view('admin.settings.site_information.index', get_defined_vars());
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
        //
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
        //
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
        $inputs = $request->except('_token');
        foreach ($inputs as $key => $input) {
            $key = str_replace('_', '.', $key);
            $setting = Setting::where('key', $key)->first();
            if (!is_null($setting)) {
                $setting->update([
                    'value' => $input
                ]);
            }


        }
        if ($request->has('')) {
            foreach ($request->appointments as $appointment) {
                $date = YmtazWorkDays::create([
                    'date' => $appointment['date'],
                    'status' => 1,
                ]);
                foreach ($appointment['time'] as $time) {
                    $time = explode('-', $time);
                    $time_from = $time[0];
                    $time_to = $time[1];
                    YmtazWorkDayTimes::create([
                        'ymtaz_available_dates_id' => $date->id,
                        'time_from' => $time_from,
                        'time_to' => $time_to,
                        'status' => 1,
                    ]);
                }

            }
        }
        return redirect()->route('admin.settings.site-information.index')->with('success', 'تم تحديث بيانات الموقع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
