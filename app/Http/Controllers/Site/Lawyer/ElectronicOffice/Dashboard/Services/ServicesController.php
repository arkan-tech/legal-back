<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Services;

use App\Http\Controllers\Controller;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {

        $lawyer = CheckElectronicOfficeLawyer($id);
        $services = Services::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.electronic_office.dashboard.services.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.services.create', get_defined_vars());

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);

        $request->validate([
            '*' => 'required',
            'image' => 'required',
        ], [
            '*.required' => 'الحقل مطلوب ',
            'image.required' => 'الحقل مطلوب '
        ]);
        Services::create([
            'lawyer_id' => $lawyer->id,
            'price' => $request->price,
            'title' => $request->title,
            'image' => saveImage($request->image, 'uploads/lawyers/electronic_office/'),
            'description' => $request->description,
        ]);
        return redirect()->route('site.lawyer.electronic-office.dashboard.services.index', $request->electronic_id_code)
            ->with('success','تم اضافة خدمة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($service_id, $id)
    {
        CheckElectronicOfficeLawyer($id);
        $service = Services::findOrFail($service_id);

        return view('site.lawyers.electronic_office.dashboard.services.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($service_id, $id)
    {
        CheckElectronicOfficeLawyer($id);
        $service = Services::findOrFail($service_id);

        return view('site.lawyers.electronic_office.dashboard.services.edit', get_defined_vars());
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
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);
        $request->validate([
            '*' => 'required',
            'image' => 'sometimes',
        ], [
            '*.required' => 'الحقل مطلوب ',
        ]);
        $service = Services::findOrFail($request->service_id);
        $service->update([
            'price' => $request->price,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        if ($request->has('image')) {
            $service->update([
                'image' => saveImage($request->image, 'uploads/lawyers/electronic_office/'),
            ]);

        }
        return redirect()->route('site.lawyer.electronic-office.dashboard.services.index', $request->electronic_id_code)  ->with('success','تم تحديث الخدمة بنجاح');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($service_id, $id)
    {
        CheckElectronicOfficeLawyer($id);
        $service = Services::findOrFail($service_id);
        $service->delete();
        return \response()->json([
            'status' => true,
        ]);
    }
}
