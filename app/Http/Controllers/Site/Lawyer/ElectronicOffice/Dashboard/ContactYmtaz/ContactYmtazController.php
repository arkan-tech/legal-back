<?php

namespace App\Http\Controllers\Site\Lawyer\ElectronicOffice\Dashboard\ContactYmtaz;

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
    public function index($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        $messages = LawyersContact::where('lawyer_id', $lawyer->id)->orderBy('created_at','DESC')->get();
        return view('site.lawyers.electronic_office.dashboard.contact_ymtaz.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id)
    {
        $lawyer = CheckElectronicOfficeLawyer($id);
        return view('site.lawyers.electronic_office.dashboard.contact_ymtaz.create', get_defined_vars());

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
        ], [
            '*.required' => 'الحقل مطلوب',
        ]);
        $lawyer = CheckElectronicOfficeLawyer($request->electronic_id_code);

        $message = LawyersContact::create([
            'lawyer_id' => $lawyer->id,
            'subject' => $request->subject,
            'details' => $request->details,
            'type' => $request->type,
        ]);
        if ($request->has('file')) {
            $message->file = saveImage($request->file, 'uploads/lawyers/contacts_ymtaz/');
            $message->save();
        }

        return redirect()->route('site.lawyer.electronic-office.dashboard.contact-ymtaz.index',$request->electronic_id_code)->with('success', 'تم ارسال رسالتك بنجاح , في انتظار الرد ');
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
