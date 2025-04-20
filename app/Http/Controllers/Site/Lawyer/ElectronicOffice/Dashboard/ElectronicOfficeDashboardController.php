<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ElectronicOffice\Services\Services;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ElectronicOfficeDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.home.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

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
