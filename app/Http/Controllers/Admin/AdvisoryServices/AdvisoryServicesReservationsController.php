<?php

namespace App\Http\Controllers\Admin\AdvisoryServices;

use App\Models\AdvisoryServicesReservations;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyersAdvisorys;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservations;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationReply;
use App\Models\AdvisoryServices\ClientAdvisoryServicesReservationsRates;
use App\Models\LawyerAdvisoryServices\LawyerAdvisoryServicesReservations;

class AdvisoryServicesReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ClientAdvisoryServicesReservations::with('client', 'service', 'type', 'importanceRel', 'lawyer')->orderBy('created_at', 'desc')->get();
            Log:
            info($data);
            return DataTables::of($data)
                ->addColumn('client', function ($row) {
                    $myname = $row->client->myname;
                    return $myname;
                })
                ->addColumn('advisory_service', function ($row) {
                    $title = $row->service->title;
                    return $title;
                })
                ->addColumn('type', function ($row) {
                    $type = $row->type->title;
                    return $type;
                })
                ->addColumn('importance_rel', function ($row) {
                    $importanceRel = is_null($row->importanceRel) ? "-" : $row->importanceRel->title;
                    return $importanceRel;
                })
                ->addColumn('price', function ($row) {
                    $price = $row->price;
                    return $price . ' ' . 'ريال';
                })
                ->addColumn('transaction_complete', function ($row) {
                    $payment_status = $row->paymentStatus();
                    return $payment_status;
                })
                ->addColumn('reservation_status', function ($row) {
                    $ReservationStatus = $row->reservation_status;
                    switch ($ReservationStatus) {
                        case 1:
                            return '  مقبول';
                            break;
                        case 2:
                            return 'تمت الاحالة إلى مستشار';
                            break;
                        case 3:
                            return ' تم القبول من المحامي ';
                            break;
                        case 4:
                            return '  قيد الدراسة ';
                            break;
                        case 5:
                            return 'تم الانتهاء';
                            break;
                        case 6:
                            return 'مرفوض من الادارة';
                            break;
                        case 7:
                            return '  ملغي من العميل';
                            break;
                    }
                })
                ->addColumn('created_at', function ($row) {
                    $created_at = GetArabicDate2($row->created_at) . ' ' . '-' . ' ' . explode(' ', GetPmAmArabic($row->created_at))[1];
                    return $created_at;
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-client-advisory-services-reservations m-1"  id="btn_delete_client_advisory_services_reservations_' . $row->id . '"  href="' . route('admin.client_advisory_services_reservations.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                          <a class="m-1 "  href="' . route('admin.client_advisory_services_reservations.edit', $row->id) . '" data-id="' . $row->id . '" title="عرض ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>
								  <a class="m-1 btn-replay-client-advisory-services-reservations"    href="' . route('admin.client_advisory_services_reservations.get.data', $row->id) . '" data-id="' . $row->id . '" title="رد على الاستشارة ">
                                     <i class="fa fa-reply"></i>
                                  </a>
                                  ';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.advisory_services.reservations.index');

    }

    public function newIndexClient()
    {
        $requests = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails')->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Services-Requests/client/index', get_defined_vars());
    }
    public function newIndexLawyer()
    {
        $requests = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails')->whereIn('for_admin', [1, 3])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Services-Requests/lawyer/index', get_defined_vars());
    }

    public function newIndexForLawyerFromClient()
    {
        $requests = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails')->whereNotNull('reserved_from_lawyer_id')->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Services-Requests/forLawyer/client/index', get_defined_vars());
    }
    public function newIndexForLawyerFromLawyer()
    {
        $requests = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails')->whereNotNull('reserved_from_lawyer_id')->where('for_admin', 2)->orderBy('created_at', 'desc')->get();
        return Inertia::render('Advisory-Services-Requests/forLawyer/lawyer/index', get_defined_vars());
    }

    public function editClient($id)
    {
        $item = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->whereIn('for_admin', [1, 3])->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Advisory-Services-Requests/client/Edit/index', get_defined_vars());
    }
    public function editClientForLawyer($id)
    {
        $item = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'client');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->where('for_admin', 2)->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Advisory-Services-Requests/forLawyer/client/Edit/index', get_defined_vars());
    }
    public function editLawyer($id)
    {
        $item = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with('account', 'subCategoryPrice.subCategory.generalCategory.paymentCategoryType', 'subCategoryPrice.importance', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->whereIn('for_admin', [1, 3])->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Advisory-Services-Requests/lawyer/Edit/index', get_defined_vars());
    }
    public function editLawyerForLawyer($id)
    {
        $item = AdvisoryServicesReservations::whereHas('account', function ($query) {
            $query->where('account_type', 'lawyer');
        })->with('account', 'subCategoryPrice.subCategory.mainCategory', 'subCategoryPrice.importance', 'lawyer.lawyerDetails.lawyerAdvisories', 'files')->where('for_admin', 2)->findOrFail($id);
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $all_lawyers = Lawyer::where('accepted', 2)->with('lawyerAdvisories')->get();
        return Inertia::render('Advisory-Services-Requests/forLawyer/lawyer/Edit/index', get_defined_vars());
    }

    public function SendFinalReplay(Request $request)
    {
        $item = ClientAdvisoryServicesReservations::with('client')->findOrFail($request->id);
        $item->update([
            'replay_content' => $request->for_admin != 1 ? null : $request->replay_message,
            'replay_status' => $request->for_admin != 1 ? 0 : 1,
            'request_status' => $request->for_admin != 1 ? 1 : 5,
            'reservation_status' => $request->for_admin != 1 ? 1 : 3,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->for_admin != 1 ? $request->lawyer_id : null,
            'replay_date' => $request->for_admin != 1 ? null : Carbon::now()->toDateString(),
            'replay_time' => $request->for_admin != 1 ? null : Carbon::now()->toTimeString(),
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null
        ]);

        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/advisory_services/replay_file/reservations/');
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
            $bodyMessage1 = ' لديك رد على الاستشارة التي طلبتها و هو :';
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
                'subject' => " رد على طلب استشارة . ",
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
        $item = ClientAdvisoryServicesReservations::findOrFail($request->id);

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
            'reservation_status' => 1,
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
        $item = AdvisoryServicesReservations::findOrFail($request->id);

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
            'reservation_status' => 1,
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
        $item = AdvisoryServicesReservations::with('client')->findOrFail($request->id);
        $item->update([
            'replay_content' => $request->for_admin != 1 ? null : $request->replay_message,
            'replay_status' => $request->for_admin != 1 ? 0 : 1,
            'request_status' => $request->for_admin != 1 ? 1 : 5,
            'reservation_status' => $request->for_admin != 1 ? 1 : 3,
            'for_admin' => $request->for_admin,
            'advisory_id' => $request->for_admin == 3 ? $request->advisory_id : null,
            'lawyer_id' => $request->for_admin != 1 ? $request->lawyer_id : null,
            'replay_date' => $request->for_admin != 1 ? null : Carbon::now()->nowWithSameTz()->toDateString(),
            'replay_time' => $request->for_admin != 1 ? null : Carbon::now()->nowWithSameTz()->toTimeString(),
            'transferTime' => $request->for_admin != 1 ? Carbon::now()->toDateTimeString() : null

        ]);
        if ($request->hasFile('file')) {
            $file = saveImage($request->file('file'), 'uploads/advisory_services/replay_file/reservations/');
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
            $bodyMessage1 = ' لديك رد على الأستشارة التي طلبتها و هو :';
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
                'subject' => " رد على طلب استشارة . ",
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
    // no used anymore
    public function replay(Request $request)
    {
        $request->validate([
            'message' => 'required',
        ], [
            'message.required' => 'يجب ترك رسالة للرد على الاستشارة'
        ]);
        Log::info($request->all());
        $replay = ClientAdvisoryServicesReservationReply::create([
            'client_reservation_id' => $request->client_reservation_id,
            'client_id' => $request->client_id,
            'reply' => $request->message,
            'from' => 2,
        ]);

        if ($request->has('attachment')) {
            $replay->attachment = saveImage($request->attachment, 'uploads/advisory_services/replay_file/reservations');
            $replay->save();
        }
        return response()->json([
            'status' => true
        ]);
    }

    public function edit($id)
    {

        $reservation = ClientAdvisoryServicesReservations::with('client', 'service', 'type', 'importanceRel', 'lawyer')->findOrFail($id);
        $lawyer_advisories_ids = LawyersAdvisorys::pluck('lawyer_id')->toArray();
        $lawyers = Lawyer::whereIN('id', $lawyer_advisories_ids)->get();
        $rate = ClientAdvisoryServicesReservationsRates::where('client_advisory_services_reservation_id', $id)->first();

        return view('admin.advisory_services.reservations.edit', get_defined_vars());

    }

    public function update(Request $request)
    {
        $request->validate([
            'reservation_status' => 'required',
            'lawyer_id' => 'required_if:reservation_status,2',
        ], [
            'reservation_status' => 'يجب اختيار حالة الاستشارة',
            'lawyer_id.required_if' => 'يجب اختيار مستشار عند احالة الاستشارة إلى مستشار',
        ]);

        $reservation = ClientAdvisoryServicesReservations::with('client', 'service', 'type', 'importanceRel', 'lawyer')->findOrFail($request->id);
        $reservation->update([
            'reservation_status' => $request->reservation_status,
            'lawyer_id' => $request->lawyer_id,
            'accept_date' => $request->reservation_status == 1 ? date("Y-m-d") : null,
        ]);
        $lawyer = Lawyer::where('id', $reservation->lawyer_id)->first();
        if ($request->reservation_status == 2) {
            $bodyMessage = 'تهانينا   ,';
            $bodyMessage1 = 'تم قبول استشارتك واحالتها الي مستشار , ';
            $bodyMessage2 = 'اسم المستشار : ' . ' ' . $lawyer->name;
            $bodyMessage3 = 'نتمنى ان تنال خدماتنا اعجابكم ,';
            $bodyMessage4 = 'لتسجيل الدخول ';
            $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
            // $bodyMessage6 = 'لاستعادة كلمة المرور :';
            // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/userTypeSelection";
            $bodyMessage6 = "";
            $bodyMessage7 = "";
            $bodyMessage8 = 'للتواصل والدعم الفني :';
            $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
            $bodyMessage10 = 'نعتز بثقتكم';
            $data = [
                'name' => $reservation->client->myname,
                'email' => ($reservation->client->email),
                'subject' => " قبول استشارتك واحالتها الي مستشار ",
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
            $msg = 'تم التحديث وارسال بريد الكتروني للعميل بتحديث حالة الاستشارة بنجاح';
        }
        $msg = 'تم التحديث بنجاح';


        return redirect()->route('admin.client_advisory_services_reservations.index')->with('success', $msg);
    }


}
