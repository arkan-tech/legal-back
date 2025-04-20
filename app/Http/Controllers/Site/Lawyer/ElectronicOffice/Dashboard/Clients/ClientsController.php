<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Models\ElectronicOffice\Clients\Clients;
use App\Models\ElectronicOffice\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {

        $lawyer = CheckElectronicOfficeLawyer($id);
        $clients = Clients::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.electronic_office.dashboard.clients.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.clients.create', get_defined_vars());
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
            'name' => 'required',
            'image' => 'required',
        ], [
            'name.required' => 'الحقل مطلوب',
            'image.required' => 'الحقل مطلوب',
        ]);
        $client = Clients::create([
            'lawyer_id' => $lawyer->id,
            'name' => $request->name,
            'image' => saveImage($request->image, 'uploads/lawyers/electronic_office/clients/')
        ]);
        return redirect()->route('site.lawyer.electronic-office.dashboard.clients.index', $request->electronic_id_code)
            ->with('success', 'تم اضافة عميل بنجاح');
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
        $client = Clients::findOrFail($service_id);

        return view('site.lawyers.electronic_office.dashboard.clients.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($client_id, $id)
    {
        CheckElectronicOfficeLawyer($id);
        $client = Clients::findOrFail($client_id);
        return view('site.lawyers.electronic_office.dashboard.clients.edit', get_defined_vars());
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
        $client = Clients::findOrFail($request->service_id);
        $client->update([
            'lawyer_id' => $lawyer->id,
            'name' => $request->name,
        ]);
        if ($request->has('image')) {
            $client->update([
                'image' => saveImage($request->image, 'uploads/lawyers/electronic_office/clients/'),
            ]);
        }
        return redirect()->route('site.lawyer.electronic-office.dashboard.clients.index', $request->electronic_id_code)->with('success', 'تم تحديث الخدمة بنجاح');

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
        $service = Clients::findOrFail($service_id);
        $service->delete();
        return \response()->json([
            'status' => true,
        ]);
    }
}
