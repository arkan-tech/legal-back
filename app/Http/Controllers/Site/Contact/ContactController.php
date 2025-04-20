<?php

namespace App\Http\Controllers\Site\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        return view('site.contact.contact');

    }

    public function contactform(Request $request)
    {
        $request->validate([
            '*'=>'required',
        ],[
            '*.required'=>'الحقل مطلوب'
        ]);
        $data = $request->except('_token');
        ContactModel::create($data);
        return response()->json([
            'status' => true,
            'msg' => 'تم استلام رسالتك بنجاح وسوف يتم التواصل معك في اقرب وقت ممكن , شكراً'
        ]);

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
