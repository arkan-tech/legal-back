<?php

namespace App\Http\Controllers\Admin\DigitalGuide\DeleteAccountRequest;

use App\Http\Controllers\Controller;
use App\Models\Lawyer\LawyerDeleteAccountRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class DigitalGuideDeleteAccountRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requests = LawyerDeleteAccountRequest::orderBy('created_at', 'desc')->get();
            return DataTables::of($requests)
                ->addColumn('lawyer', function ($row) {
                    $name = $row->lawyer->name;
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
                     <a class="m-1 btn-show-digital-guide-delete-account-request"    href="' . route('admin.digital-guide.delete-accounts.show', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                    <a class="m-1 "    href="' . route('admin.digital-guide.delete-accounts.edit', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-edit"></i>
                                  </a>
                                    <a class="btn-delete-digital-guide-delete-account-request m-1"  id="btn_delete_digital_guide_delete_account_request_' . $row->id . '"  href="' . route('admin.digital-guide.delete-accounts.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                 ';
                    return $actions;
                })
                ->make(true);
        }
        return view('admin.digital_guide.delete_accounts_requests.index');
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
        $item = LawyerDeleteAccountRequest::with('lawyer')->findOrFail($id);
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
        $request = LawyerDeleteAccountRequest::with('lawyer')->findOrFail($id);
        return view('admin.digital_guide.delete_accounts_requests.edit', compact('request'));

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
        $item = LawyerDeleteAccountRequest::with('lawyer')->findOrFail($request->id);
        $item->update([
            'status' => $request->status,
        ]);
        if ($request->status == 1) {
            $item->lawyer->update([
                'accepted' => 0,
            ]);

            $lawyer_bodyMessage = 'نعتذر لك شريكنا العزيز:';
            $lawyer_bodyMessage1 = 'لقد تم حجب  او تعليق حسابكم في منصة يمتاز القانونية اما بناء على طلبكم أو لسبب قررته الإدارة المختصة ';
            $lawyer_bodyMessage2 = 'في حال كان الحظر خاطئاً أو غير مبرر، فيمكنكم مراسلة الإدارة عبر هذا الرابط :';
            $lawyer_bodyMessage3 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage4 = '';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            $bodyMessage7 = '';
            $bodyMessage8 = '';
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $item->lawyer->name,
                'email' => $item->lawyer->email,
                'subject' => " الرد على طلب حذف حساب في تطبيق يمتاز  . ",
                'bodyMessage' => $lawyer_bodyMessage,
                'bodyMessage1' => $lawyer_bodyMessage1,
                'bodyMessage2' => $lawyer_bodyMessage2,
                'bodyMessage3' => $lawyer_bodyMessage3,
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
                $lawyer_data,
                function ($message) use ($lawyer_data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($lawyer_data['email'], $lawyer_data['name'])->subject($lawyer_data['subject']);
                }
            );
        } else if ($request->status == 2) {

            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' ' . ' يؤسفنا اخبارك بانه تم رفض  طلب حذف حسابك ';
            $bodyMessage2 = ' ';
            $bodyMessage3 = 'لتسجيل الدخول ';
            $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage5 = 'لاستعادة كلمة المرور :';
            // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage5 = "";
            $bodyMessage6 = "";
            $bodyMessage7 = 'للتواصل والدعم الفني :';
            $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage9 = '';
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $item->lawyer->name,
                'email' => $item->lawyer->email,
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
        }
        return redirect()->route('admin.digital-guide.delete-accounts.edit', $request->id)->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $request = LawyerDeleteAccountRequest::with('lawyer')->findOrFail($id);
        $request->delete();
        return \response()->json([
            'status' => true,
        ]);
    }
}
