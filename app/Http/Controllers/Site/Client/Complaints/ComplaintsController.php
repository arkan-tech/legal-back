<?php

namespace App\Http\Controllers\Site\Client\Complaints;

use App\Http\Controllers\Controller;
use App\Models\Complaint\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $request->validate([
        'complaint_body'=>'required',
     ],[
         'complaint_body.required'=>'الحقل مطلوب'
     ]);

     Complaint::create([
        'lawyer_id'=>$request->lawyer_id,
        'client_id'=>auth()->guard('client')->user()->id,
         'complaint_body'=>$request->complaint_body
     ]);

     return response()->json([
        'status'=>true,
        'msg'=>'تم استلام الشكوى بنجاح , وسوف نقوم بالتعامل مع الشكوى في اقرب وقت , شكراً لكم .'
     ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
