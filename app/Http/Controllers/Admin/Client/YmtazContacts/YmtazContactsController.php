<?php

namespace App\Http\Controllers\Admin\Client\YmtazContacts;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientsContact;
use App\Models\Lawyer\LawyersContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class YmtazContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $messages = ClientsContact::with('client')->orderBy('created_at', 'desc')->get();
        if ($request->ajax()) {
            return DataTables::of($messages)
                ->addColumn('client_name', function ($row) {

                    return $row->client->myname;
                })
                ->addColumn('client_email', function ($row) {

                    return $row->client->email;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-client-ymtaz-message m-1"  id="btn_delete_client_ymtaz_message_' . $row->id . '"  href="' . route('admin.clients.ymtaz-contacts.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-replay-client-ymtaz-message"    href="' . route('admin.clients.ymtaz-contacts.show', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.clients.ymtaz_contacts.index');
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
        $message = ClientsContact::with('client')->findOrFail($id);
        return \response()->json([
            'status' => true,
            'message' => $message
        ]);
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
        $message = ClientsContact::findORfail($id);
        $message->delete();
        return response()->json([
            'status' => true,

        ]);
    }

    public function replay(Request $request)
    {
        $request->validate([
            'replay_message' => 'required',
            'ymtaz_reply_subject' => 'required',
        ]);

        $message = ClientsContact::findOrFail($request->id);
        $message->update([
            'ymtaz_reply_subject' => $request->ymtaz_reply_subject,
            'reply' => $request->replay_message,
        ]);
        return \response()->json([
            'status' => true
        ]);
    }
}
