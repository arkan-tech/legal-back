<?php

namespace App\Http\Controllers\Admin\Client;

use Inertia\Inertia;
use App\Models\Account;
use App\Models\City\City;
use App\Models\LawyerOld;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ServiceUserOld;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Exports\ExportServiceUsers;
use App\Models\Country\Nationality;
use App\Models\Service\ServiceUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\Admin\Client\ClientAdminUpdateProfileRequest;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = ServiceUser::with('country')->orderBy('created_at', 'desc')->orderBy('created_at', 'desc')->get();
            return DataTables::of($clients)
                ->addColumn('accepted', function ($row) {
                    $status = $row->accepted;
                    switch ($status) {
                        case 1:
                            return '<div class="  bg-primary text-white">جديد</div>';
                            break;
                        case 2:
                            return '<div class="  bg-success  text-white">مقبول</div>';
                            break;
                        case 3:
                            return '<div class=" bg-warning  text-white">انتظار</div>';
                            break;
                        case 0:
                            return '<div class=" bg-danger  text-white">محظور</div>';
                            break;
                    }

                })
                ->addColumn('type', function ($row) {
                    $type = $row->type;
                    switch ($type) {
                        case 1:
                            return 'فرد';
                            break;
                        case 2:
                            return 'مؤسَّسة';
                            break;
                        case 3:
                            return 'شركة';
                            break;
                        case 4:
                            return 'جهة حكومية';
                            break;
                        case 5:
                            return 'اخرى';
                            break;
                        case null:
                            return '--';
                            break;
                    }

                })
                ->addColumn('country', function ($row) {
                    if (!is_null($row->country_id)) {
                        return $row->country->name;
                    } else {
                        return 'غير محدد';
                    }

                })
                ->addColumn('mobil', function ($row) {
                    return str_replace($row->phone_code, '', $row->mobil);
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-client m-1"  id="btn_delete_client_' . $row->id . '"  href="' . route('admin.clients.destroy', $row->id) . '"data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"    href="' . route('admin.clients.edit', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>
                                  <a class="btn-client-send-email m-1"    href="#" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-reply"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);

        }
        return view('admin.clients.index');

    }
    public function newIndex()
    {
        $clients = Account::with(['country', 'region'])->where('account_type', 'client')
            ->select(
                'accounts.*',
                DB::raw('CASE
                                WHEN status = 1 THEN "جديد"
                                WHEN status = 2 THEN "مقبول"
                                WHEN status = 3 THEN "انتظار"
                                WHEN status = 0 THEN "محظور"
                                ELSE "" END as accepted_text'),
                DB::raw('CASE
                                WHEN type = 1 THEN "فرد"
                                WHEN type = 2 THEN "مؤسَّسة"
                                WHEN type = 3 THEN "شركة"
                                WHEN type = 4 THEN "جهة حكومية"
                                WHEN type = 5 THEN "اخرى"
                                ELSE "--" END as type_text')
            )
            ->orderByDesc('created_at')
            ->get();
        $clients->each(function ($client) {
            // Check if client exists in ServiceUserOld
            $oldUser = ServiceUserOld::where('email', $client->email)
                ->orWhere(function ($query) use ($client) {
                    $query->where('mobil', $client->phone)
                        ->where('phone_code', $client->phone_code);
                })->first();

            // If not found in ServiceUserOld, check LawyerOld
            if (is_null($oldUser)) {
                $oldUser = LawyerOld::where('email', $client->email)
                    ->orWhere(function ($query) use ($client) {
                        $query->where('phone', $client->phone)
                            ->where('phone_code', $client->phone_code);
                    })->first();
            }

            // Add custom attribute 'is_old_user' to the client
            $client->is_old_user = !is_null($oldUser);
        });
        return Inertia::render('Clients/Clients', [
            'clients' => $clients
        ]);
    }
    public function oldClientsIndex()
    {
        $clients = ServiceUserOld::with(['country', 'region'])
            ->select(
                'service_users_old.*',
                DB::raw('CASE
                                WHEN accepted = 1 THEN "جديد"
                                WHEN accepted = 2 THEN "مقبول"
                                WHEN accepted = 3 THEN "انتظار"
                                WHEN accepted = 0 THEN "قديم"
                                ELSE "" END as accepted_text'),
                DB::raw('CASE
                                WHEN type = 1 THEN "فرد"
                                WHEN type = 2 THEN "مؤسَّسة"
                                WHEN type = 3 THEN "شركة"
                                WHEN type = 4 THEN "جهة حكومية"
                                WHEN type = 5 THEN "اخرى"
                                ELSE "--" END as type_text')
            )
            ->orderByDesc('created_at')
            ->get();
        return Inertia::render('Old-Clients/Clients', [
            'clients' => $clients
        ]);
    }

    public function getTypes()
    {
        $types = [
            (object) ['id' => 1, 'name' => 'فرد'],
            (object) ['id' => 2, 'name' => 'مؤسَّسة'],
            (object) ['id' => 3, 'name' => 'شركة'],
            (object) ['id' => 4, 'name' => 'جهة حكومية'],
            (object) ['id' => 5, 'name' => 'اخرى'],
        ];

        return $types;
    }
    public function EditView($id)
    {
        $types = $this->getTypes();
        $client = Account::where('account_type', 'client')->findOrFail($id);
        $nationalities = Nationality::where('status', 1)->get();
        $countries = Country::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $success = session('successMessage');
        return Inertia::render('Clients/EditClient', get_defined_vars());
    }
    public function OldEditView($id)
    {
        $types = $this->getTypes();
        $client = ServiceUserOld::findOrFail($id);
        $nationalities = Nationality::where('status', 1)->get();
        $countries = Country::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $success = session('successMessage');
        return Inertia::render('Old-Clients/EditClient', get_defined_vars());
    }
    public function ExportUsers(Request $request)
    {
        return Excel::download(new ExportServiceUsers, 'clients.xlsx');
    }

    public function SendEmail(Request $request)
    {
        $client = Account::findOrFail($request->id);
        $bodyMessage = ' مرحباً ' . ' ' . $client->name . ' ' . ' عميلنا العزيز  ';
        $bodyMessage1 = 'نحمل لك رسالة من ادارة يمتاز ومحتواها كالتالي :  .';
        $bodyMessage2 = 'العنوان : ' . ' ' . $request->message_subject;
        $bodyMessage3 = 'نص الرسالة : ' . ' ' . $request->message_body;
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
            'name' => $client->name,
            'email' => $client->email,
            'subject' => "  رسالة من ادارة يمتاز ",
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

        return \response()->json([
            'status' => true
        ]);
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
        $client = Account::where('account_type', 'client')->findOrFail($id);
        $nationalities = Nationality::where('status', 1)->get();
        $countries = Country::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        return view('admin.clients.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function update(ClientAdminUpdateProfileRequest $request)
    {

        $client = Account::findOrFail($request->id);

        $accepted = CheckIfAnyChaneINClientAccepted($request->status, $client);
        $client->update([
            'name' => $request->name,
            'phone_code' => $request->phone_code,
            'mobil' => $request->mobil,
            'type' => $request->type,
            'email' => $request->email,
            'nationality_id' => $request->nationality_id,
            'country_id' => $request->country_id,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            'gender' => $request->gender,
            'status' => $request->status,
        ]);
        $oldUser = ServiceUserOld::where('email', $request->email)->orWhere(['mobil' => $request->mobil, 'phone_code' => $request->phone_code])->first();
        if (!is_null($oldUser)) {
            if ($oldUser->accepted == 0) {
                $oldUser->update([
                    'accepted' => 1
                ]);
            }
        } else {
            $oldUser = LawyerOld::where('email', $request->email)->orWhere(['phone' => $request->mobil, 'phone_code' => $request->phone_code])->first();

            if (!is_null($oldUser)) {
                if ($oldUser->accepted == 0) {
                    $oldUser->update([
                        'accepted' => 1
                    ]);
                }
            }
        }
        // TODO: Add controlling the emails for client
        if ($accepted['status'] === 'change') {
            $new_status = $accepted['new_status'];
            $reason = $accepted['status_reason'];
            switch ($new_status) {
                // تم الانتهاء من الرسائل هذه من طرف ابو الفهد في يوم 26-2-2024 الساعة 1:07 مساءاً
                case 0:
                    // ok
                    $bodyMessage = 'نعتذر لك شريكنا العزيز:';
                    $bodyMessage1 = 'لقد تم حجب أو تعليق حسابكم في منصة يمتاز القانونية إما بناء على طلبكم أو لسبب قررته الإدارة المختصة.';
                    // $bodyMessage2 = 'في حال كان هذا الحظر خاطئاً أو غير مبرر، فيمكنكم مراسلة الإدارة القانونية للمنصة عبر هذا الرابط :';
                    // $bodyMessage3 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage2 = '';
                    $bodyMessage3 = $reason != '' ? 'السبب : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'ولكم تحياتنا';
                    break;
                case 1:
                    // ok
                    $bodyMessage = ' تهانينا لك شريكنا العزيز.';
                    $bodyMessage1 = 'لقد تمت عملية تسجيل حسابكم كطالب خدمة بتطبيق يمتاز بنجاح، وتمت إضافة ٥٠ نقطة في حسابك الآن.';
                    // $bodyMessage2 = ' لتسجيل الدخول : ️';
                    // $bodyMessage3 = env('REACT_WEB_LINK') . "/auth/signin";
                    // $bodyMessage4 = '  لاستعادة كلمة المرور : ️';
                    // $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
                    // $bodyMessage6 = ' للتواصل والدعم الفني : ️';
                    // $bodyMessage7 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage2 = 'ستكتسب ١٠٠ نقطة إضافية حال استكمال بيانات ملفكم الشخصي. ';
                    $bodyMessage3 = $reason != '' ? 'السبب : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';

                    break;
                case 2:
                    // ok
                    $bodyMessage = ' تهانينا لك شريكنا العزيز. ';
                    $bodyMessage1 = 'لقد تم تفعيل حسابكم كطالب خدمة بتطبيق يمتاز بنجاح، وتمت إضافة ١٠٠ نقطة جديدة في حسابكم لقاء استكمال بيانات ملفكم الشخصي.';
                    $bodyMessage2 = 'يمكنكم الآن الاطلاع على ملفكم الشخصي والتمتع بخصائص عضوية طالب الخدمة الكاملة بكل يسر وسهولة.';
                    // $bodyMessage3 = ' لتسجيل الدخول : ️';
                    // $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
                    // $bodyMessage5 = '  لاستعادة كلمة المرور : ️';
                    // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
                    // $bodyMessage7 = ' للتواصل والدعم الفني : ️';
                    // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage3 = $reason != '' ? 'السبب : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    break;
                case 3:
                    // ok
                    $bodyMessage = "  أهلا ً بك شريكنا العزيز  ";
                    $bodyMessage1 = 'نحيطكم أن حسابكم كطالب خدمة بمنصة يمتاز القانونية هو في حالة انتظار تحديث البيانات.';
                    $bodyMessage2 = 'نأمل منكم استكمال البيانات اللازمة للتحديث، لتنشيط حسابكم مجدداً.';
                    // $bodyMessage3 = ' لتسجيل الدخول : ️';
                    // $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
                    // $bodyMessage5 = '  لاستعادة كلمة المرور : ';
                    // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=client";
                    // $bodyMessage7 = ' للتواصل والدعم الفني : ';
                    // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage3 = $reason != '' ? 'السبب : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    break;
            }

            $data = [
                'name' => $client->name,
                'email' => $client->email,
                'subject' => " تحديث حالة حسابكم في يمتاز",
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

        $request->session()->flash('successMessage', 'تم تحديث البيانات بنجاح');
        return to_route('newAdmin.clientEdit', ['id' => $client->id]);
    }
    public function updateOld(Request $request)
    {

        $client = ServiceUserOld::findOrFail($request->id);

        $client->update([
            'accepted' => $request->accepted
        ]);

        $request->session()->flash('successMessage', 'تم تحديث البيانات بنجاح');
        return to_route('newAdmin.oldClientsEdit', ['id' => $client->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $client = Account::findOrFail($id);
        $client->delete();
        return to_route('newAdmin.clientsIndex');

    }
    public function oldDestroy($id)
    {
        $client = ServiceUserOld::findOrFail($id);
        $client->delete();
        return to_route('newAdmin.oldClientsIndex');

    }

    public function getRegionsBaseCountryId($id)
    {
        $regions = Regions::where('country_id', $id)->get();
        $items_html = view('admin.clients.includes.edit.region-select', compact('regions'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function getCitiesBaseRegionId($id)
    {
        $cities = City::where('region_id', $id)->get();
        $items_html = view('admin.clients.includes.edit.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

}