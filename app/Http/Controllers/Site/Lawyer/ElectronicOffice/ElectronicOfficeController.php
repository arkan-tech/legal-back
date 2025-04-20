<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice;

use App\Http\Controllers\Controller;
use App\Models\ElectronicOffice\Clients\Clients;
use App\Models\ElectronicOffice\Services\Services;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElectronicOfficeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
//    public function index($id)
    public function index()
    {
//        CheckElectronicOfficeLawyer($id);
//        return view('site.lawyers.electronic_office.home.index', get_defined_vars());
        return view('site.lawyers.electronic_office.empty');

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

    }

    public function services($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $services = Services::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.electronic_office.services.index', get_defined_vars());
    }

    public function servicesShow($service_id, $id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $service = Services::where('id',$service_id)->where('lawyer_id', $lawyer->id)->first();
        return view('site.lawyers.electronic_office.services.show', get_defined_vars());
    }

    public function clients($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $clients = Clients::where('lawyer_id', $lawyer->id)->get();
        return view('site.lawyers.electronic_office.clients.index', get_defined_vars());
    }

    public function blog($id)
    {
        CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.blog.index', get_defined_vars());
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
