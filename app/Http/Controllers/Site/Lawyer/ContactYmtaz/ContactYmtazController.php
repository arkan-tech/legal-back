<?php

namespace App\Http\Controllers\Site\Lawyer\ContactYmtaz;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyersContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactYmtazController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $lawyer = auth()->guard('lawyer')->user();

        $messages = LawyersContact::where('lawyer_id', $lawyer->id)->get();

        return view('site.lawyers.ContactYmtaz.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $lawyer = auth()->guard('lawyer')->user();
        return view('site.lawyers.ContactYmtaz.create', get_defined_vars());
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
            'file' => 'sometimes',
        ]);
        $data = $request->except('_token', 'file');
        $message = LawyersContact::create($data);
        if ($request->has('file')) {
            $message->file = saveImage($request->file('file'), 'uploads/lawyers/contacts_ymtaz/');
            $message->save();
        }
        return \response()->json([
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
