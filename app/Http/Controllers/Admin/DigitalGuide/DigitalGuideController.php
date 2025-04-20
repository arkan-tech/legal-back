<?php

namespace App\Http\Controllers\Admin\DigitalGuide;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Account;
use App\Models\AppTexts;
use App\Models\City\City;
use App\Models\LawyerOld;
use Illuminate\Http\Request;
use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use Illuminate\Http\Response;
use App\Exports\ExportLawyers;
use App\Models\ServiceUserOld;
use App\Models\Country\Country;
use App\Models\Regions\Regions;
use Yajra\DataTables\DataTables;
use App\Models\Country\Nationality;
use App\Models\Districts\Districts;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Lawyer\LawyerSections;
use App\Models\Lawyer\LawyersAdvisorys;
use App\Models\Specialty\GeneralSpecialty;
use App\Models\Specialty\AccurateSpecialty;
use App\Models\FunctionalCases\FunctionalCases;
use App\Models\AdvisoryCommittee\AdvisoryCommittee;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Requests\Admin\DigitalGuide\StoreDigitalGhideRequest;

class DigitalGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $lawyers = Lawyer::orderBy('updated_at', 'desc')->orderBy('created_at', 'desc')->get();
            return DataTables::of($lawyers)
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
                ->addColumn('country', function ($row) {
                    if (!is_null($row->country_id)) {
                        return $row->country->name;
                    } else {
                        return 'غير محدد';
                    }

                })
                ->addColumn('phone', function ($row) {
                    return str_replace($row->phone_code, '', $row->phone);
                })
                ->addColumn('action', function ($row) {
                    $actions = '<a class="btn-delete-digital-guid m-1"  id="btn_delete_digital_guid_' . $row->id . '"  href="' . route('admin.digital-guide.delete', $row->id) . '" data-id="' . $row->id . '" title="حذف ">
                                      <i class="fa fa-trash"></i>
                                  </a>
                                  <a class="m-1"    href="' . route('admin.digital-guide.editById', $row->id) . '" data-id="' . $row->id . '" title="تعديل ">
                                     <i class="fa-solid fa-user-pen"></i>
                                  </a>';
                    return $actions;
                })
                ->rawColumns(['action', 'accepted'])
                ->make(true);
        }
        return view('admin.digital_guide.index');
    }

    public function newIndex(Request $request)
    {

        $lawyers = Lawyer::select(
            'lawyers.*',
            DB::raw('CASE
                                WHEN status = 1 THEN "جديد"
                                WHEN status = 2 THEN "مقبول"
                                WHEN status = 3 THEN "انتظار"
                                WHEN status = 0 THEN "محظور"
                                ELSE "" END as accepted_text'),
        )
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        $countries = Country::get();
        $cities = City::get();
        $regions = Regions::get();
        $lawyers->each(function ($lawyer) {
            // Check if lawyer exists in LawyerOld
            $oldUser = LawyerOld::where('email', $lawyer->email)
                ->orWhere(function ($query) use ($lawyer) {
                    $query->where('phone', $lawyer->phone)
                        ->where('phone_code', $lawyer->phone_code);
                })->first();

            // If not found in LawyerOld, check ServiceUserOld
            if (is_null($oldUser)) {
                $oldUser = ServiceUserOld::where('email', $lawyer->email)
                    ->orWhere(function ($query) use ($lawyer) {
                        $query->where('mobil', $lawyer->phone)
                            ->where('phone_code', $lawyer->phone_code);
                    })->first();
            }

            // Add custom attribute 'is_old_user' to the lawyer
            $lawyer->is_old_user = !is_null($oldUser);
        });
        return Inertia::render('Lawyers/Lawyers', [
            "lawyers" => $lawyers,
            "countries" => $countries,
            "cities" => $cities,
            "regions" => $regions
        ]);
    }
    public function oldLawyersIndex(Request $request)
    {

        $lawyers = LawyerOld::select(
            'lawyers_old.*',
            DB::raw('CASE
                                WHEN accepted = 0 THEN "قديم"
                                WHEN accepted = 1 THEN "جديد"
                                ELSE "" END as accepted_text'),
        )
            ->orderByDesc('updated_at')
            ->orderByDesc('created_at')
            ->get();
        $countries = Country::get();
        $cities = City::get();
        $regions = Regions::get();
        return Inertia::render('Old-Lawyers/Lawyers', [
            "lawyers" => $lawyers,
            "countries" => $countries,
            "cities" => $cities,
            "regions" => $regions
        ]);
    }


    public function ExportLawyers()
    {
        return Excel::download(new ExportLawyers, 'lawyers.xlsx');
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

        $lawyer = Account::with('lawyerDetails')->where('account_type', 'lawyer')->findOrFail($id);

        $countries = Country::where('status', 1)->get();
        $nationalities = Nationality::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $districts = Districts::where('status', 1)->get();
        $degrees = Degree::where('isYmtaz', 1)->where('status', 1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $GeneralSpecialty = GeneralSpecialty::where('status', 1)->get();
        $AccurateSpecialty = AccurateSpecialty::where('status', 1)->get();
        $lawyer_advisories = LawyersAdvisorys::where('account_details_id', $lawyer->lawyerDetails()->id)->pluck('advisory_id')->toArray();
        $functional_cases = FunctionalCases::where('status', 1)->get();
        $lawyer_sections = LawyerSections::with('section')->where('account_details_id', $lawyer->lawyerDetails()->id)->get();
        return view('admin.digital_guide.edit', get_defined_vars());
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
        $lawyer = Lawyer::with('lawyerDetails', 'pricingCommittee')->findOrFail($id);
        $birthday = $lawyer->lawyerDetails->year . '-' . $lawyer->lawyerDetails->month . '-' . $lawyer->lawyerDetails->day;
        $birthdayDateTime = is_null($lawyer->lawyerDetails->year) || is_null($lawyer->lawyerDetails->month) || is_null($lawyer->lawyerDetails->day) ? null : Carbon::parse($birthday);
        $lawyer["birthdate"] = $birthdayDateTime;
        $countries = Country::where('status', 1)->get();
        $nationalities = Nationality::where('status', 1)->get();
        $regions = Regions::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $districts = Districts::where('status', 1)->get();
        $degrees = Degree::where('isYmtaz', 1)->where('status', 1)->get();
        $sections = DigitalGuideCategories::where('status', 1)->get();
        $advisories = AdvisoryCommittee::where('status', 1)->get();
        $GeneralSpecialty = GeneralSpecialty::where('status', 1)->get();
        $AccurateSpecialty = AccurateSpecialty::where('status', 1)->get();
        $lawyer_advisories = LawyersAdvisorys::where('account_details_id', $lawyer->lawyerDetails->id)->pluck('advisory_id')->toArray();
        $functional_cases = FunctionalCases::where('status', 1)->get();
        $lawyer_sections = LawyerSections::with('section')->where('account_details_id', $lawyer->lawyerDetails->id)->get();
        $success = session('successMessage');

        return Inertia::render('Lawyers/EditLawyer', get_defined_vars());
    }
    public function OldEditView($id)
    {
        $lawyer = LawyerOld::findOrFail($id);
        $countries = Country::where('status', 1)->get();
        $success = session('successMessage');

        return Inertia::render('Old-Lawyers/EditLawyer', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return
     */
    public function update(StoreDigitalGhideRequest $request)
    {
        $date = explode('-', $request->birth_date);
        $lawyer = Account::where('account_type', "=", 'lawyer')->findOrFail($request->id);

        $phone = $request->phone;
        if (!is_null($lawyer->phone) && $request->status == 2) {
            $check = Account::where('id', '<>', $request->id)->where('phone', $phone)->first();
            if (!is_null($check)) {
                return redirect()->back()->with('error-sections', ' رقم الجوال موجود مسبقاً');
            }

        }

        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                if (!is_null($section['sections'])) {
                    $item = DigitalGuideCategories::where('status', 1)->where('id', $section)->first();
                    if ($item->need_license == 1) {
                        if (is_null($section['licence_no'])) {
                            return redirect()->back()->with('error-sections', ' ' . 'المهنة : ' . $item->title . ' تحتاج إلى رقم ترخيص وملف ترخيص , يرجى المراجعة جيداً  ');
                        }
                        if (!array_key_exists('licence_file', $section)) {
                            return redirect()->back()->with('error-sections', ' ' . 'المهنة : ' . $item->title . ' تحتاج إلى رقم ترخيص وملف ترخيص, يرجى المراجعة جيداً  ');
                        }
                        if (is_null($section['licence_file'])) {
                            return redirect()->back()->with('error-sections', ' ' . 'المهنة : ' . $item->title . ' تحتاج إلى رقم ترخيص وملف ترخيص, يرجى المراجعة جيداً  ');
                        }
                    }
                    LawyerSections::create([
                        'account_details_id' => $lawyer->lawyerDetails->id,
                        'section_id' => $section['sections'],
                        'licence_no' => $section['licence_no'],
                        'licence_file' => !is_null($section['licence_file']) ? saveImage($section['licence_file'], 'uploads/lawyers/license_file/') : null,
                    ]);
                }


            }

        }
        if ($request->type == 2) {
            $lawyer_sections = LawyerSections::where('account_details_id', $lawyer->lawyerDetails->id)->first();
            if (is_null($lawyer_sections)) {
                return redirect()->back()->with('error-sections', 'مقدم الخدمة ليس لديه مهن , ويجب اضافة مهنة واحدة على الاقل  ');
            }
        }


        $accepted = CheckIfAnyChaneINLawyerAccepted($request->status, $lawyer);
        $show_in_advoisory_website = $request->show_in_advisory_website;
        $show_at_digital_guide = $request->show_at_digital_guide;

        $old_is_advisor = $lawyer->is_advisor;
        $new_is_advisor = $request->is_advisor;


        $name = implode(" ", array_filter([$request->fname, $request->sname, $request->tname == "null" ? null : $request->tname, $request->fourthname]));
        $lawyer->update([
            'name' => $name,

            'status' => $request->status,
            'phone_code' => $request->phone_code,
            'phone' => $phone,
            'email' => $request->email,
            'type' => $request->type,
            'gender' => $request->gender,
            'nationality_id' => $request->nationality,
            'country_id' => $request->country_id,
            'region_id' => $request->region,
            'city_id' => $request->city,
            'email_confirmation' => 1,
            'phone_confirmation' => 1
        ]);
        $lawyer->lawyerDetails->update([
            'day' => array_key_exists('2', $date) ? $date[2] : null,
            'month' => array_key_exists('1', $date) ? $date[1] : null,
            'year' => array_key_exists('0', $date) ? $date[0] : null,
            'company_liences_no' => $request->company_lisences_no,
            'company_name' => $request->company_name,
            'about' => $request->about,
            'identity_type' => $request->identity_type,
            'nat_id' => $request->nat_id,
            'general_specialty' => $request->general_specialty,
            'accurate_specialty' => $request->accurate_specialty,
            'functional_cases' => $request->functional_cases,
            'degree' => $request->degree,
            'is_advisor' => $request->is_advisor,
            'show_in_advisory_website' => $show_in_advoisory_website,
            // 'office_request' => $request->office_request,
            // 'office_request_status' => $request->office_request_status,
            // 'office_request_from' => $request->office_request_from,
            // 'office_request_to' => $request->office_request_to,
            'digital_guide_subscription' => $request->digital_guide_subscription,
            // 'digital_guide_subscription_from' => $request->digital_guide_subscription_from,
            // 'digital_guide_subscription_to' => $request->digital_guide_subscription_to,


            'show_at_digital_guide' => $show_at_digital_guide,

            'is_special' => $request->special,

        ]);
        if ($request->is_pricing_committee == 0) {
            if ($lawyer->pricingCommittee()->exists()) {
                $lawyer->pricingCommittee()->delete();
            }
        } else {
            $lawyer->pricingCommittee()->updateOrCreate(
                ['account_id' => $lawyer->id],
                [
                    'account_id' => $lawyer->id,
                ]
            );
        }

        $oldUser = LawyerOld::where('email', $request->email)->orWhere(['phone' => $request->phone, 'phone_code' => $request->phone_code])->first();
        if (!is_null($oldUser)) {
            if ($oldUser->accepted == 0) {
                $oldUser->update([
                    'accepted' => 1
                ]);
            }
        } else {
            $oldUser = ServiceUserOld::where('email', $request->email)->orWhere(['mobil' => $request->phone, 'phone_code' => $request->phone_code])->first();

            if (!is_null($oldUser)) {
                if ($oldUser->accepted == 0) {
                    $oldUser->update([
                        'accepted' => 1
                    ]);
                }
            }
        }
        if ($request->has('profile_photo')) {
            $personal_image = saveImage($request->file('profile_photo'), 'uploads/lawyers/personal_image/');
            $lawyer->profile_photo = $personal_image;
            $lawyer->save();
        }
        // } else if (!$request->has('photo')) {
        //     $lawyer->photo = null;
        //     $lawyer->save();
        // }
        if ($request->has('company_licences_file')) {
            $company_lisences_file = saveImage($request->file('company_licences_file'), 'uploads/lawyers/company_lisences_file/');
            $lawyer->lawyerDetails->company_licences_file = $company_lisences_file;
            $lawyer->save();
        }
        if ($request->has('logo')) {
            $logo = saveImage($request->file('logo'), 'uploads/lawyers/logo/');
            $lawyer->lawyerDetails->logo = $logo;
            $lawyer->save();
        } else if (!$request->has('logo')) {
            $lawyer->lawyerDetails->logo = null;
            $lawyer->save();
        }
        if ($request->has('national_id_image')) {
            $national_id_image = saveImage($request->file('id_file'), 'uploads/lawyers/national_id_image/');
            $lawyer->lawyerDetails->national_id_image = $national_id_image;
            $lawyer->save();
        }

        if ($request->has('cv_file')) {
            $cv_file = saveImage($request->file('cv_file'), 'uploads/lawyers/cv/');
            $lawyer->lawyerDetails->cv_file = $cv_file;
            $lawyer->save();
        }
        if ($request->has('degree_certificate')) {
            $degree_certificate = saveImage($request->file('degree_certificate'), 'uploads/lawyers/degree_certificate/');
            $lawyer->lawyerDetails->degree_certificate = $degree_certificate;
            $lawyer->save();
        }

        if ($request->is_advisor == 1) {
            $items = LawyersAdvisorys::where('account_details_id', $lawyer->lawyerDetails->id)->get();
            foreach ($items as $item) {
                $item->delete();
            }
            foreach ($request->advisor_cat_id as $cat) {
                LawyersAdvisorys::create([
                    'account_details_id' => $lawyer->lawyerDetails->id,
                    'advisory_id' => $cat,
                ]);
            }
        } else {
            $items = LawyersAdvisorys::where('account_details_id', $lawyer->lawyerDetails->id)->get();
            foreach ($items as $item) {
                $item->delete();
            }
        }
        if ($accepted['status'] === 'change') {
            $new_status = $accepted['new_status'];
            $reason = $request->status_reason;
            switch ($new_status) {
                // تم الانتهاء من الرسائل هذه من طرف ابو الفهد في يوم 26-2-2024 الساعة 1:13 مساءاً
                case 0:
                    $bodyMessage = 'نعتذر لك عميلنا العزيز:';
                    $bodyMessage1 = nl2br(AppTexts::where('key', 'account-blocked')->first()->value);
                    $bodyMessage2 = '';
                    // $bodyMessage2 = 'في حال كان هذا الحظر خاطئاً أو غير مبرر، فيمكنكم مراسلة الإدارة القانونية للمنصة عبر هذا الرابط :';
                    // $bodyMessage3 = env('REACT_WEB_LINK') . "/contact-us";
                    $bodyMessage3 = $reason != '' ? 'الملاحظة : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    $show_in_advoisory_website = 0;
                    $show_at_digital_guide = 0;
                    break;
                case 1:
                    // ok
                    $bodyMessage = 'تهانينا لك شريكنا العزيز.';
                    $bodyMessage1 = nl2br(AppTexts::where('key', 'account-new')->first()->value);
                    // $bodyMessage2 = ' لتسجيل الدخول : ️';
                    // $bodyMessage3 = env('REACT_WEB_LINK') . "/auth/signin";
                    $bodyMessage2 = '';
                    $bodyMessage3 = $reason != '' ? 'الملاحظة : ' . nl2br($reason) : '';
                    // $bodyMessage4 = '  لاستعادة كلمة المرور : ️';
                    // $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/userTypeSelection";
                    $bodyMessage4 = "";
                    $bodyMessage5 = "";
                    $bodyMessage6 = ' للتواصل والدعم الفني : ️';
                    $bodyMessage7 = env('REACT_WEB_LINK') . "/contact-us";
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    $show_in_advoisory_website = 1;
                    $show_at_digital_guide = 1;

                    break;
                case 2:
                    // ok
                    $bodyMessage = 'تهانينا لكم شريكنا العزيز.';
                    $bodyMessage1 = nl2br(AppTexts::where('key', 'account-accepted')->first()->value);
                    $bodyMessage2 = '';
                    // $bodyMessage3 = ' لتسجيل الدخول : ️';
                    // $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
                    // $bodyMessage5 = '  لاستعادة كلمة المرور : ️';
                    // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/userTypeSelection";
                    // $bodyMessage7 = ' للتواصل والدعم الفني : ️';
                    // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage3 = $reason != '' ? 'الملاحظة : ' . nl2br($reason) : '';
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
                    $bodyMessage1 = AppTexts::where('key', 'account-pending')->first()->value;
                    $bodyMessage2 = '';
                    // $bodyMessage3 = ' لتسجيل الدخول : ️';
                    // $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
                    // $bodyMessage5 = '  لاستعادة كلمة المرور : ️';
                    // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/userTypeSelection";
                    // $bodyMessage7 = ' للتواصل والدعم الفني : ️';
                    // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";

                    $bodyMessage3 = $reason != '' ? 'الملاحظة : ' . nl2br($reason) : '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = '';
                    $bodyMessage8 = '';
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    $show_in_advoisory_website = 0;
                    $show_at_digital_guide = 0;
                    break;
            }

            $data = [
                'name' => $lawyer->name,
                'email' => $lawyer->email,
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
        if ($new_is_advisor == 1) {
            if ($old_is_advisor == 0) {
                $advisor_cats = AdvisoryCommittee::whereIN('id', $request->advisor_cat_id)->pluck('title')->toArray();
                $bodyMessage = ' تهانينا لك عميلنا العزيز :';
                $bodyMessage1 = 'نحيطكم أن حسابكم كمقدم خدمة بمنصة يمتاز تم اضافته إلى هيئة استشارية و هي  .';
                $bodyMessage2 = implode(' , ', $advisor_cats);
                // $bodyMessage3 = ' لتسجيل الدخول : ️';
                // $bodyMessage4 = env('REACT_WEB_LINK') . "/auth/signin";
                // $bodyMessage5 = '  لاستعادة كلمة المرور : ️';
                // $bodyMessage6 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
                // $bodyMessage7 = ' للتواصل والدعم الفني : ️';
                // $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";

                $bodyMessage3 = '';
                $bodyMessage4 = '';
                $bodyMessage5 = '';
                $bodyMessage6 = '';
                $bodyMessage7 = '';
                $bodyMessage8 = '';
                $bodyMessage9 = '';
                $bodyMessage10 = 'نعتز بثقتكم';
                $data = [
                    'name' => $lawyer->name,
                    'email' => $lawyer->email,
                    'subject' => "  تهانينا لك عميلنا العزيز ",
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
        }
        $request->session()->flash('successMessage', "تم تعديل الملف بنجاح");
        return to_route('newAdmin.lawyerEdit', $lawyer->id);
    }
    public function oldUpdate(Request $request)
    {
        $lawyer = LawyerOld::where('id', $request->id)->firstOrFail();
        $request->validate([
            'first_name' => 'required',
            'second_name' => 'required',
            'third_name' => 'sometimes',
            'fourth_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'phone_code' => 'required',
        ], [
            '*.required' => 'هذا الحقل مطلوب',
        ]);
        $lawyer->first_name = $request->first_name;
        $lawyer->second_name = $request->second_name;
        $lawyer->third_name = $request->third_name ?? "";
        $lawyer->fourth_name = $request->fourth_name;
        $name = implode(" ", array_filter([$request->first_name, $request->second_name, $request->third_name, $request->fourth_name]));

        $lawyer->name = $name;
        $lawyer->email = $request->email;
        $lawyer->phone = $request->phone;
        $lawyer->phone_code = $request->phone_code;
        $lawyer->save();

        return to_route('newAdmin.oldLawyersIndex', $lawyer->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return
     */
    public function destroy($id)
    {
        $lawyer = Account::findOrFail($id);
        $lawyer->delete();
        return to_route('newAdmin.lawyerIndex');
    }
    public function oldDestroy($id)
    {
        $lawyer = LawyerOld::findOrFail($id);
        $lawyer->delete();
        return to_route('newAdmin.oldLawyersIndex');
    }

    public function DestroySection($id)
    {
        $section = LawyerSections::findOrFail($id);
        $section->delete();
        return \response()->json([
            'status' => true
        ]);
    }

    public function EditSection($id)
    {
        $section = LawyerSections::with('section')->findOrFail($id);
        return \response()->json([
            'status' => true,
            'section' => $section
        ]);
    }

    public function UpdateSection(Request $request)
    {
        dd($request->all());
    }


    public function getRegionsBaseCountryId($id)
    {
        $regions = Regions::where('country_id', $id)->get();
        $items_html = view('admin.digital_guide.includes.edit.region-select', compact('regions'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function getCitiesBaseRegionId($id)
    {
        $cities = City::where('region_id', $id)->get();
        $items_html = view('admin.digital_guide.includes.edit.cities-select', compact('cities'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

    public function getDistrictsBaseCityId($id)
    {
        $districts = Districts::where('city_id', $id)->get();
        $items_html = view('admin.digital_guide.includes.edit.districts-select', compact('districts'))->render();
        return response()->json([
            'status' => true,
            'items_html' => $items_html
        ]);
    }

}