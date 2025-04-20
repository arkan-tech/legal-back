<?php

namespace App\Http\Controllers\Admin\Client\DeleteAccountRequest;

use App\Http\Controllers\Controller;
use App\Models\Client\ClientDeleteAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class DeleteAccountRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requests = ClientDeleteAccountRequest::orderBy('created_at', 'desc')->get();
            return DataTables::of($requests)
                ->addColumn('client', function ($row) {
                    $name = $row->client->myname;
                    return $name;
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    switch ($status) {
                        case 0:
                            return 'قيد الدراسة';
                            break;
                        case 1:
                            return 'مقبول';
                            break;
                        case 2:
                            return 'مرفوض';
                            break;
                    }
                })
                ->addColumn('created_at', function ($row) {
                    $created_at = GetArabicDate2($row->created_at) . ' ' . '-' . ' ' . explode(' ', GetPmAmArabic($row->created_at))[1];
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $actions = '
                     <a class="m-1 btn-show-client-delete-account-request"    href="' . route('admin.clients.delete-accounts-requests.show', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                    <a class="m-1 "    href="' . route('admin.clients.delete-accounts-requests.edit', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-edit"></i>
                                  </a>
                                    <a class="btn-delete-client-delete-account-request m-1"  id="btn_delete_client_delete_account_request_' . $row->id . '"  href="' . route('admin.clients.delete-accounts-requests.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                 ';
                    return $actions;
                })
                ->make(true);
        }
        return view('admin.clients.delete_accounts_requests.index');
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
        $item = ClientDeleteAccountRequest::with('client')->findOrFail($id);
        return \response()->json([
            'status' => true,
            'item' => $item
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
        $request = ClientDeleteAccountRequest::with('client')->findOrFail($id);
        return view('admin.clients.delete_accounts_requests.edit', compact('request'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $item = ClientDeleteAccountRequest::with('client')->findOrFail($request->id);
        $item->update([
            'status' => $request->status,
        ]);
        if ($request->status == 1) {
            $item->client->update([
                //                'status' => 0,
                'accepted' => 0,
            ]);


            $client_bodyMessage = 'نعتذر لك شريكنا العزيز:';
            $client_bodyMessage1 = 'لقد تم حجب  او تعليق حسابكم في منصة يمتاز القانونية اما بناء على طلبكم أو لسبب قررته الإدارة المختصة ';
            $client_bodyMessage2 = 'في حال كان الحظر خاطئاً أو غير مبرر، فيمكنكم مراسلة الإدارة عبر هذا الرابط :';
            $client_bodyMessage3 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage4 = '';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            $bodyMessage7 = '';
            $bodyMessage8 = '';
            $bodyMessage9 = '';
            $bodyMessage10 = 'ولكم تحياتنا';
            $client_data = [
                'name' => $item->client->myname,
                'email' => $item->client->email,
                'subject' => " الرد على طلب حذف حساب في تطبيق يمتاز  . ",
                'bodyMessage' => $client_bodyMessage,
                'bodyMessage1' => $client_bodyMessage1,
                'bodyMessage2' => $client_bodyMessage2,
                'bodyMessage3' => $client_bodyMessage3,
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
                $client_data,
                function ($message) use ($client_data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($client_data['email'], $client_data['name'])->subject($client_data['subject']);
                }
            );
        } else if ($request->status == 2) {
            $item->client->update([
                'status' => 1,
                'active' => 1
            ]);
            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' ' . ' يؤسفنا اخبارك بانه تم رفض  طلب حذف حسابك ';
            $bodyMessage2 = ' ';
            $bodyMessage3 = 'لتسجيل الدخول ';
            $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
            $bodyMessage5 = 'لاستعادة كلمة المرور :';
            $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $item->client->myname,
                'email' => $item->client->email,
                'subject' => " الرد على طلب حذف حساب في تطبيق يمتاز  . ",
                'bodyMessage' => $bodyMessage,
                'bodyMessage1' => $bodyMessage1,
                'bodyMessage2' => $bodyMessage2,
                'bodyMessage3' => $bodyMessage3,
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
        } else {
            $item->client->update([
                'status' => 1
            ]);
        }
        return redirect()->route('admin.clients.delete-accounts-requests.edit', $request->id)->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $request = ClientDeleteAccountRequest::with('client')->findOrFail($id);
        $request->delete();
        return \response()->json([
            'status' => true,
        ]);
    }
}
