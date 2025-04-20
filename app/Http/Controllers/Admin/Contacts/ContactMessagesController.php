<?php

namespace App\Http\Controllers\Admin\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact\Contact;
use App\Models\Contact\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class ContactMessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $messages = ContactModel::orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get();
            return DataTables::of($messages)
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-message m-1"  id="btn_delete_message_' . $row->id . '"  href="' . route('admin.contact.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-show-message"    href="' . route('admin.contact.show', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                                  <a class="m-1 btn-replay-message"    href="' . route('admin.contact.show', $row->id) . '"  data-id="' . $row->id . ' ">
                                      <i class="fa-solid fa-reply"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.contact_messages.index');
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

        $message = ContactModel::findOrFail($id);
        return \response()->json([
            'status' => true,
            'message' => $message,
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
        $message = ContactModel::findOrFail($id);
        $message->delete();
        return \response()->json([
            'status' => true,
        ]);
    }

    public function replayMessage(Request $request)
    {

        $message = ContactModel::findOrFail($request->id);
        $bodyMessage3 = 'لتسجيل الدخول ';
        $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage5 = 'لاستعادة كلمة المرور :';
        // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/userTypeSelection";
        $bodyMessage5 = "";
        $bodyMessage6 = "";
        $bodyMessage7 = 'للتواصل والدعم الفني :';
        $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage9 = '';
        $bodyMessage10 = 'نعتز بثقتكم';
        $data = [
            'name' => $message->name,
            'email' => $message->email,
            'subject' => " رد على موضوع رسالة :" . $message->subject,
            'bodyMessage' => 'رسالتك : ' . $message->message,
            'bodyMessage1' => 'الرد : ' . $request->replay_message,
            'bodyMessage2' => '',
            'bodyMessage3' => '',
            'bodyMessage4' => $bodyMessage4,
            'bodyMessage5' => $bodyMessage5,
            'bodyMessage6' => $bodyMessage6,
            'bodyMessage7' => $bodyMessage7,
            'bodyMessage8' => $bodyMessage8,
            'bodyMessage9' => $bodyMessage9,
            'bodyMessage10' => $bodyMessage10,
            'platformLink' => env('REACT_WEB_LINK'),

        ];
        Mail::send(
            'email',
            $data,
            function ($message) use ($data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($data['email'], $data['name'])->subject($data['subject']);
            }
        );
        return \response()->json(['status' => true]);
    }
}
