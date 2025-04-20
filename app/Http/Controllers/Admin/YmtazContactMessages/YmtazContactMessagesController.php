<?php

namespace App\Http\Controllers\Admin\YmtazContactMessages;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyersContact;
use App\Models\LawyerYmtazContact\LawyerYmtazContact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class YmtazContactMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $messages = LawyerYmtazContact::with('lawyer')->orderBy('created_at', 'desc')->get();
        if ($request->ajax()) {
            return DataTables::of($messages)
                ->addColumn('lawyer_name', function ($row) {

                    return $row->lawyer->name;
                })
                ->addColumn('lawyer_email', function ($row) {

                    return $row->lawyer->email;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-message m-1"  id="btn_delete_ymtaz_message_' . $row->id . '"  href="' . route('admin.ymtaz-contacts.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-replay-ymtaz-message"    href="' . route('admin.ymtaz-contacts.show', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-eye"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('admin.ymtaz_contacts.index');
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
        $message = LawyerYmtazContact::with('lawyer')->findOrFail($id);
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
        $message = LawyerYmtazContact::with('lawyer')->findOrFail($id);
        $message->delete();
        return \response()->json([
            'status' => true,
        ]);
    }

    public function replay(Request $request)
    {
        $request->validate([
            'replay_message' => 'required',
            'ymtaz_reply_subject' => 'required',
        ]);
        $message = LawyerYmtazContact::findOrFail($request->id);
        $message->update([
            'ymtaz_reply_subject' => $request->ymtaz_reply_subject,
            'reply' => $request->replay_message,
        ]);
        return \response()->json([
            'status' => true
        ]);
    }

}
