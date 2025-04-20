<?php

namespace App\Http\Controllers\Site\Client\YmtazContact;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientsContact;
use App\Models\Lawyer\LawyersContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function response;

class ClientYmtazContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $client = auth()->guard('client')->user();

        $messages = ClientsContact::where('client_id', $client->id)->get();

        return view('site.client.ContactYmtaz.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $client = auth()->guard('client')->user();
        return view('site.client.ContactYmtaz.create', get_defined_vars());
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
        $message = ClientsContact::create([
            'client_id' => $request->client_id,
            'subject' => $request->subject,
            'details' => $request->details,
            'type' => $request->type,
        ]);
        if ($request->has('file')) {
            $message->file = saveImage($request->file('file'), 'uploads/client/contacts_ymtaz/');
            $message->save();
        }
        return response()->json([
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
