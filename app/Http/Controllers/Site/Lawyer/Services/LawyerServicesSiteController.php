<?php

namespace App\Http\Controllers\Site\Lawyer\Services;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyerSections;
use App\Models\Lawyer\LawyersServicesPrice;
use App\Models\Service\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LawyerServicesSiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawyer = auth()->guard('lawyer')->user();
        $lawyerSections = LawyerSections::where('lawyer_id', $lawyer->id)->pluck('section_id')->toArray();
        $services = Service::where('status', 1)->where(function ($q) use ($lawyerSections) {
            foreach ($lawyerSections as $section) {
                $q->orWhere("section_id", "like", "%" . $section . "%");
            }
        })->get();
        $lawyerServicesPrices = LawyersServicesPrice::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.services.prices', compact('lawyer', 'services', 'lawyerServicesPrices'));
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
        $inputs = $request->all();
        $lawyerServicesPrices = LawyersServicesPrice::where('lawyer_id', $request->lawyer_id)->get();

        if ($lawyerServicesPrices) {
            $lawyerServicesPrices->each->delete();
        }
        foreach ($inputs['group-c'] as $group) {
            $service = Service::where('id', $group['service'])->first();
            $check_if_between = in_range($group['service_price'], $service->min_price, $service->max_price);
            if ($check_if_between) {
                $price = new LawyersServicesPrice;
                $price->lawyer_id = $request->lawyer_id;
                $price->service_id = $service->id;
                $price->price = $group['service_price'];
                $price->save();

            } else {
                continue;
            }


        }
        return response()->json(['status' => true]);
    }

    public function checkServicePrice(Request $request)
    {
        $service = Service::where('status', 1)->where('status', 1)->find($request->servID);

        if ($request->price >= $service->min_price && $request->price <= $service->max_price) {
            return response()->json(['success' => 1]);
        } else {
            return response()->json(['success' => 0, 'min_price' => $service->min_price, 'max_price' => $service->max_price]);
        }

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
    public function update(Request $request, $id)
    {
        //
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
