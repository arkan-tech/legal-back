<?php

namespace App\Http\Controllers\Admin\Client\ServiceRequest;

use App\Models\ServicesReservations;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Client\ClientRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyersAdvisorys;
use App\Models\Client\ClientRequestRates;
use App\Models\Client\ClientRequestReplies;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\LawyerServicesRequest\LawyerServicesRequest;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $requests = ClientRequest::with('client', 'type')->orderBy('created_at', 'desc')->get();
            Log::info($requests);
            return DataTables::of($requests)
                ->addColumn('client', function ($row) {
                    $name = $row->client->myname;
                    if (is_null($row->client->deleted_at)) {
                        return $name;
                    } else {
                        return '<del class="text-danger">' . $name . '</del>';
                    }
                })
                ->addColumn('service', function ($row) {
                    $title = $row->type->title;
                    return $title;
                })
                ->addColumn('priority', function ($row) {
                    $priority = $row->priority;
                    if ($priority == 1) {
                        return 'عجل جداً';
                    } else {
                        return 'مرتبط بموعد';
                    }
                })
                ->addColumn('status', function ($row) {
                    $status = $row->status;
                    if ($status == 1) {
                        return ' مفتوحة';
                    } else {
                        return ' مغلقة';
                    }
                })
                ->addColumn('replay_status', function ($row) {
                    $replay_status = $row->replay_status;
                    if ($replay_status == 1) {
                        return ' تم الرد';
                    } else {
                        return ' انتظار';
                    }
                })
                ->addColumn('referral_status', function ($row) {
                    $referral_status = $row->referral_status;
                    switch ($referral_status) {
                        case 0:
                            return 'انتظار';
                            break;
                        case 1:
                            return ' محال';
                            break;
                        case 2:
                            return ' دراسة الطلب';
                            break;
                        case 3:
                            return '  انهاء الطلب';
                            break;
                        case 4:
                            return '   مرفوض من المستشار';
                            break;

                    }
                })
                ->addColumn('file', function ($row) {
                    $file = $row->file;

                    if (!is_null($file)) {
                        return '<a href="' . $file . '" target="_blank" title="المرفقات">
                                                        المرفقات
                                                    </a>';
                    } else {
                        return 'لا يوجد';
                    }

                })
                ->addColumn('replay_status', function ($row) {
                    $replay_status = $row->replay_status;

                    if ($replay_status == 0) {
                        return 'انتظار';
                    } else {
                        return ' تم الرد';
                    }

                })
                ->addColumn('transaction_complete', function ($row) {
                    $status = $row->transaction_complete;
                    if ($status == 0) {
                        return 'غير مدفوع';
                    }
                    if ($status == 1) {
                        return 'مدفوع';
                    } elseif ($status == 2) {
                        return 'ملغي';
                    } else {
                        return 'مرفوض';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    $created_at = GetArabicDate2($row->created_at) . ' ' . '-' . ' ' . explode(' ', GetPmAmArabic($row->created_at))[1];
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-client-service-request m-1"  id="btn_delete_client_service_request_' . $row->id . '"  href="' . route('admin.clients.service-request.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1 btn-show-client-service-request"    href="' . route('admin.clients.service-request.show', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                                  <a class="m-1 btn-edit-client-service-request"    href="' . route('admin.clients.service-request.edit', $row->id) . '"  data-id="' . $row->id . '" >
                                     <i class="fa-solid fa-edit"></i>
                                  </a>

                                  <a class="m-1 btn-replay-client-service-request "    href="' . route('admin.clients.service-request.show', $row->id) . '"  data-id="' . $row->id . ' ">
                                       <i class="fa-solid fa-reply"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'file', 'client'])
                ->make(true);
        }
        //        <a class="m-1 "  target="_blank"   href="' . route('admin.clients.service-request.replay', $row->id) . '"  data-id="' . $row->id . ' ">
//
//                                      <i class="fa-solid fa-message"></i>
//                                  </a>
        return view('admin.clients.service-request.index');
    }

    public function newIndexClient()
    {
        $requests = ServicesReservations::whereHas(
            'account',
            function ($query) {
                $query->where('account_type', 'client');
            }
        )->with([
                    'account',
                    'type',
                    'lawyer',
                    'files'
                ])->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Service-Requests/client/index', get_defined_vars());
    }
    public function newIndexLawyer()
    {
        $requests = ServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with([
                    'account',
                    'type',
                    'lawyer',
                    'files'
                ])->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Service-Requests/lawyer/index', get_defined_vars());
    }
    public function newIndexForLawyerFromClient()
    {
        $requests = ServicesReservations::whereHas(
            'account',
            function ($query) {
                $query->where('account_type', 'client');
            }
        )->with([
                    'account',
                    'type',
                    'lawyer',
                    'files',
                    'priorityRel'
                ])->whereNotNull('reserved_from_lawyer_id')->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Service-Requests/forLawyer/client/index', get_defined_vars());
    }
    public function newIndexForLawyerFromLawyer()
    {
        $requests = ServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with([
                    'account',
                    'type',
                    'lawyer',
                    'files',
                    'priorityRel'
                ])->whereNotNull('reserved_from_lawyer_id')->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Service-Requests/forLawyer/lawyer/index', get_defined_vars());
    }
    public function editClient($id)
    {
        $item = ServicesReservations::with('account', 'type', 'priorityRel', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->whereIn('for_admin', [1, 3])->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Service-Requests/client/Edit/index', get_defined_vars());
    }
    public function editClientForLawyer($id)
    {
        $item = ServicesReservations::with('account', 'type', 'priorityRel', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->where('for_admin', 2)->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Service-Requests/forLawyer/client/Edit/index', get_defined_vars());
    }
    public function editLawyer($id)
    {
        $item = ServicesReservations::with('account', 'type', 'priorityRel', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->whereIn('for_admin', [1, 3])->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Service-Requests/lawyer/Edit/index', get_defined_vars());
    }
    public function editLawyerForLawyer($id)
    {
        $item = ServicesReservations::with('account', 'type', 'priorityRel', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->where('for_admin', 2)->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Service-Requests/forLawyer/lawyer/Edit/index', get_defined_vars());
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
        $item = ClientRequest::with('client', 'type')->findOrFail($id);
        $rate = ClientRequestRates::where('client_service_request_id', $id)->where('client_id', $item->client->id)->first();
        return \response()->json([
            'status' => true,
            'item' => $item,
            'rate' => $rate
        ]);
    }

    public function replay($id)
    {
        $item = ClientRequest::with('client', 'type')->findOrFail($id);
        $item_replies = ClientRequestReplies::where('client_requests_id', $id)->get();
        return view('admin.clients.service-request.chat', get_defined_vars());

    }

    public function replayClientServiceRequest(Request $request)
    {
        $item = ClientRequest::with('client', 'type')->findOrFail($request->client_requests_id);
        $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
        $bodyMessage2 = $request->replay_message;
        $bodyMessage3 = '';
        $data = [
            'name' => $item->client->myname,
            'email' => ($item->client->email),
            'subject' => " رد على طلب خدمة . ",
            'bodyMessage' => $bodyMessage,
            'bodyMessage1' => $bodyMessage1,
            'bodyMessage2' => $bodyMessage2,
            'bodyMessage3' => $bodyMessage3,
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
        $item->update([
            'replay_status' => 1
        ]);

        $replay = ClientRequestReplies::create([
            'client_requests_id' => $item->id,
            'replay' => $request->replay_message,
            'from_admin' => 1,
            'replay_laywer_id' => null,
            'from' => 2,
        ]);
        $file = null;
        if ($request->has('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request');
            $replay->file = $file;
            $replay->update();
            $file = $replay->file;
        }
        return \response()->json([
            'status' => true,
            'item' => $item,
            'file' => $file,
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
        $item = ClientRequest::with('client', 'type')->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $lawyers = Lawyer::where('id', $item->lawyer_id)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->get();
        return view('admin.clients.service-request.edit', get_defined_vars());
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
        $request->validate([
            'for_admin' => 'required',
            'advisory_id' => 'required_if:for_admin,2',
            'lawyer_id' => 'required_if:for_admin,2',
            'direct_lawyer_id' => 'required_if:for_admin,3',
        ], [
            'advisory_id.required_if' => 'يجب اختيار هيئة عندما تتم احالة التذكرة إلى هيئات ',
            'lawyer_id.required_if' => 'يجب اختيار مشتشار عندما تتم احالة التذكرة إلى هيئات ',
            'direct_lawyer_id.required_if' => 'يجب اختيار مشتشار عندما تتم احالة التذكرة إلى مستشار ',
        ]);
        $item = ClientRequest::with('client', 'type')->findOrFail($request->id);
        if ($request->for_admin == 3) {
            $advisory_id = LawyersAdvisorys::where('lawyer_id', $request->direct_lawyer_id)->first();
            if (is_null($advisory_id)) {
                return redirect()->route('admin.clients.service-request.edit', $request->id)->with('error_adv', 'يجب العودة إلى صفحة المستشار واضافته الى هيئة استشارية');
            }
        }
        $lawyer = Lawyer::where('id', $request->for_admin == 3 ? $request->direct_lawyer_id : $request->lawyer_id)->first();

        $old_lawyer_id = $item->lawyer_id;
        $old_replay_status = $item->replay_status;
        $old_referral_status = $item->referral_status;
        if (!is_null($lawyer)) {
            if ($old_lawyer_id != $lawyer->id) {
                $replay_status = 0;
            } else {
                $replay_status = $old_replay_status;
            }

        } else {
            $replay_status = $old_replay_status;
        }

        $item->update([
            'payment_status' => $request->payment_status,
            'status' => $request->status,
            'price' => $request->payment_status == 1 ? $request->price : null,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $advisory_id->advisory_id : $request->advisory_id,
            'lawyer_id' => $request->for_admin == 3 ? $request->direct_lawyer_id : $request->lawyer_id,
            'replay_status' => $replay_status,
            'referral_status' => $request->referral_status,
            'request_status' => 1,

        ]);
        if (in_array($item->for_admin, [2, 3])) {
            $client = ServiceUser::where('id', $item->client_id)->first();
            $lawyer = Lawyer::where('id', $item->lawyer_id)->first();
            $client_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $client_bodyMessage1 = ' ' . ' يسعدنا اخبارك بانه تم تحويل استشارتك إلى المستشار :' . ' ' . $lawyer->name;
            $client_bodyMessage2 = 'يمكنك المتابعة طلباتك واستشاراتك من خلال الرابط التالي : ';
            $client_bodyMessage3 = route('site.client.service-request.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $client_data = [
                'name' => $client->myname,
                'email' => $client->email,
                'subject' => " تحويل استشارتك إلى  . ",
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
            $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $lawyer_bodyMessage1 = ' تم تحويل لك استشارة عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (طلبات مُحالة لك ):';
            $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
            $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "تحويل استشارة جديدة من يمتاز . ",
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

        }
        return redirect()->route('admin.clients.service-request.edit', $request->id)->with('success', ' تم تحديث بيانات الطلب بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = ClientRequest::with('client', 'type')->findOrFail($id);
        $item->delete();
        return \response()->json([
            'status' => true
        ]);
    }

    public function getLawyersBaseAdvisoryId($adv_id, $item_id)
    {
        $lawyers_ids = LawyersAdvisorys::where('advisory_id', $adv_id)->pluck('lawyer_id')->toArray();
        $lawyers = Lawyer::whereIN('id', $lawyers_ids)->where('accepted', 2)->get();
        $item = ClientRequest::where('id', $item_id)->first();
        $items_html = view('admin.clients.service-request.lawyers-select', compact('lawyers', 'item'))->render();

        return \response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function SendFinalReplay(Request $request)
    {
        $item = ClientRequest::with('client')->findOrFail($request->id);
        $item->update([
            'replay' => $request->for_admin != 1 ? null : $request->replay_message,
            'replay_from_admin' => $request->for_admin != 1 ? 0 : 1,
            'replay_status' => $request->for_admin != 1 ? 0 : 1,
            'request_status' => $request->for_admin != 1 ? 1 : 5,
            'referral_status' => $request->for_admin != 1 ? 1 : 3,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->for_admin != 1 ? $request->lawyer_id : null,
            'replay_date' => $request->for_admin != 1 ? null : Carbon::now()->toDateString(),
            'replay_time' => $request->for_admin != 1 ? null : Carbon::now()->toTimeString(),
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null
        ]);

        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/client/service_request/replay_file/');
            $item->update(['replay_file' => $file]);
        }
        if ($request->for_admin == 3) {
            $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
            $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $lawyer_bodyMessage1 = ' تم تحويل لك استشارة عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (طلبات مُحالة لك ):';
            $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
            $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "تحويل استشارة جديدة من يمتاز . ",
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
        } else {

            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
            $bodyMessage2 = $request->replay_message;
            $bodyMessage3 = !is_null($item->replay_file) ? 'الملف : ' . ' ' . $item->replay_file : '';
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $item->client->myname,
                'email' => ($item->client->email),
                'subject' => " رد على طلب خدمة . ",
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
        return \response()->json([
            'status' => true
        ]);
    }
    public function SendFinalReplayForClientFromLawyer(Request $request)
    {
        $item = ClientRequest::findOrFail($request->id);

        $lawyer = Lawyer::where('id', $item->lawyer_id)->first();
        if (!is_null($lawyer)) {

            $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $lawyer_bodyMessage1 = ' تم تحويل منك استشارة عميل';
            $lawyer_bodyMessage2 = "";
            $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "تحويل استشارة جديدة منك الى يمتاز . ",
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
        }
        $item->update([
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->lawyer_id,
            'referral_status' => 1,
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null
        ]);
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $lawyer_bodyMessage1 = ' تم تحويل لك استشارة عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (طلبات مُحالة لك ):';
        $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
        $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
        $bodyMessage4 = 'لتسجيل الدخول ';
        $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage6 = 'لاستعادة كلمة المرور :';
        // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
        $bodyMessage6 = "";
        $bodyMessage7 = "";
        $bodyMessage8 = 'للتواصل والدعم الفني :';
        $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage10 = 'نعتز بثقتكم';
        $lawyer_data = [
            'name' => $lawyer->name,
            'email' => $lawyer->email,
            'subject' => "تحويل استشارة جديدة من يمتاز . ",
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
        return \response()->json([
            'status' => true
        ]);
    }
    public function SendFinalReplayForLawyerFromLawyer(Request $request)
    {
        $item = LawyerServicesRequest::findOrFail($request->id);

        $lawyer = Lawyer::where('id', $item->lawyer_id)->first();
        if (!is_null($lawyer)) {

            $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $lawyer_bodyMessage1 = ' تم تحويل منك استشارة عميل';
            $lawyer_bodyMessage2 = "";
            $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "تحويل استشارة جديدة منك الى يمتاز . ",
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
        }
        $item->update([
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->lawyer_id,
            'referral_status' => 1,
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null
        ]);
        $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
        $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
        $lawyer_bodyMessage1 = ' تم تحويل لك استشارة عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (طلبات مُحالة لك ):';
        $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
        $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
        $bodyMessage4 = 'لتسجيل الدخول ';
        $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage6 = 'لاستعادة كلمة المرور :';
        // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
        $bodyMessage6 = "";
        $bodyMessage7 = "";
        $bodyMessage8 = 'للتواصل والدعم الفني :';
        $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage10 = 'نعتز بثقتكم';
        $lawyer_data = [
            'name' => $lawyer->name,
            'email' => $lawyer->email,
            'subject' => "تحويل استشارة جديدة من يمتاز . ",
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
        return \response()->json([
            'status' => true
        ]);
    }
    public function SendFinalReplayLawyer(Request $request)
    {
        $item = LawyerServicesRequest::with('client')->findOrFail($request->id);
        $item->update([
            'replay' => $request->for_admin != 1 ? null : $request->replay_message,
            'replay_from_admin' => $request->for_admin != 1 ? 0 : 1,
            'replay_status' => $request->for_admin != 1 ? 0 : 1,
            'request_status' => $request->for_admin != 1 ? 1 : 5,
            'referral_status' => $request->for_admin != 1 ? 1 : 3,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->for_admin != 1 ? $request->lawyer_id : null,
            'replay_date' => $request->for_admin != 1 ? null : Carbon::now()->nowWithSameTz()->toDateString(),
            'replay_time' => $request->for_admin != 1 ? null : Carbon::now()->nowWithSameTz()->toTimeString(),
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null

        ]);
        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/lawyer/service_request/replay_file/');
            $item->update(['replay_file' => $file]);
        }
        if ($request->for_admin == 3) {
            $lawyer = Lawyer::where('id', $request->lawyer_id)->first();
            $lawyer_bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $lawyer_bodyMessage1 = ' تم تحويل لك استشارة عميل نرجو منك مراجعة البروفايل الخاص بك  في قائمة (طلبات مُحالة لك ):';
            $lawyer_bodyMessage2 = ' ' . 'وصف الاستشارة هو : ' . ' ' . $item->description;
            $lawyer_bodyMessage3 = ' ' . ' يمكنك الدخول على الطلبات المحالة لك من خلال الرابط التالي : ' . ' ' . route('site.lawyer.clients-service-requests.index');
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $lawyer_data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
                'subject' => "تحويل استشارة جديدة من يمتاز . ",
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
        } else {
            $bodyMessage = " مرحباً بك عميلنا  العزيز .  ";
            $bodyMessage1 = ' لديك رد على الخدمة التي طلبتها و هو :';
            $bodyMessage2 = $request->replay_message;
            $bodyMessage3 = !is_null($item->replay_file) ? 'الملف : ' . ' ' . $item->replay_file : '';
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $item->client->myname,
                'email' => ($item->client->email),
                'subject' => " رد على طلب خدمة . ",
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
        return \response()->json([
            'status' => true
        ]);
    }


}
