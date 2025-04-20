<?php

namespace App\Http\Tasks\Lawyer\Auth\Register;

use App\Models\Activity;
use App\Models\Language;
use App\Models\LawyerOld;
use App\Models\Newsletter;
use App\Http\Tasks\BaseTask;
use App\Models\ReferralCode;
use App\Models\Degree\Degree;
use App\Models\Lawyer\Lawyer;
use App\Models\ServiceUserOld;
use Illuminate\Support\Facades\Mail;

use App\Models\Lawyer\LawyerSections;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Http\Resources\API\Lawyer\LawyerDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;
use App\Http\Requests\API\Lawyer\Auth\Register\LawyerRegisterRequest;

class LawyerRegisterTask extends BaseTask
{
    public function run(LawyerRegisterRequest $request)
    {
        $phone = $request->phone;
        $check = Lawyer::where('phone', $phone)->first();
        if (!is_null($check)) {
            return $this->sendResponse(false, 'رقم الجوال موجود مسبقاً ', ["errors" => ["mobile" => ['رقم الجوال موجود مسبقاً']]], 422);
        }

        $special_degree_certificate_check = false;
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                $item = DigitalGuideCategories::where('status', 1)->where('id', $section)->first();
                if (!is_null($item)) {
                    if ($item->need_license == 1) {
                        $check = array_key_exists($section, $request->licence_no);
                        if ($check == false) {
                            return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها رقم الترخيص . وشكراً ', null, 422);
                        }
                        $check = array_key_exists($section, $request->license_file);
                        if ($check == false) {
                            return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها ملف اثيات الترخيص . وشكراً ', null, 422);
                        }
                        $special_degree_certificate_check = true;
                    }
                }
            }
        }


        $degree = Degree::where('isYmtaz', 1)->findOrFail($request->degree);
        if ($degree->title == "أخرى") {
            if (!array_key_exists('degree_certificate', $request->all())) {
                return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
            }
            $degree = Degree::create([
                'title' => $request->other_degree,
            ]);
        } else {
            if ($special_degree_certificate_check) {
                if ($degree->isSpecial) {
                    if (!array_key_exists('degree_certificate', $request->all())) {
                        return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
                    }
                }
            } else {
                if (!array_key_exists('degree_certificate', $request->all())) {
                    return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
                }
            }
        }





        $lawyer_name = $request->first_name . ' ' . $request->second_name . ' ' . $request->third_name . ' ' . $request->fourth_name;
        $day = strlen($request->birth_day) == 1 ? '0' . $request->birth_day : $request->birth_day;
        $month = strlen($request->birth_month) == 1 ? '0' . $request->birth_month : $request->birth_month;
        $birthday = $request->birth_year . '-' . $month . '-' . $day;

        $lawyer = Lawyer::create([
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'third_name' => $request->third_name || "",
            'fourth_name' => $request->fourth_name,
            'name' => $lawyer_name,
            'status' => 3,
            'username' => $lawyer_name,
            'email' => $request->email,
            'phone_code' => $request->phone_code,
            'phone' => $phone,
            'password' => bcrypt($request->password),
            'about' => $request->about,
            'accurate_specialty' => $request->accurate_specialty,
            'general_specialty' => $request->general_specialty,
            'gender' => $request->gender,
            'degree' => $degree->id,
            'paid_status' => 0,
            'is_advisor' => 0,
            'accepted' => 1,
            'special' => 0,
            'digital_guide_subscription' => 0,
            'office_request' => 0,
            'show_at_digital_guide' => 1,
            'office_request_status' => 0,
            'profile_complete' => 1,
            'day' => $day,
            'month' => $month,
            'year' => $request->birth_year,
            'birthday' => $birthday,
            'nationality' => $request->nationality,
            'country_id' => $request->country,
            'region' => $request->region,
            'city' => $request->city,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'type' => $request->type,
            'identity_type' => $request->identity_type,
            'nat_id' => $request->nat_id,
            'functional_cases' => $request->functional_cases,
            'licence_no' => json_encode($request->licence_no),
            'accept_rules' => $request->accept_rules,
            'company_lisences_no' => $request->company_lisences_no,
            'company_name' => $request->company_name,
            'activate_email' => 0,
            'sections' => json_encode($request->sections),
            'referred_by' => $request->referred_by,
            'level_id' => 1,
            'rank_id' => 1,
        ]);

        $lawyer->additionalInfo()->create([
            'degree' => $degree->id,
            'about' => $request->about,
            'is_advisor' => 0,
            'day' => $day,
            'month' => $month,
            'year' => $request->birth_year,
            'accurate_specialty' => $request->accurate_specialty,
            'general_specialty' => $request->general_specialty,
            'functional_cases' => $request->functional_cases,
            'digital_guide_subscription' => 0,
            'show_at_digital_guide' => 1,
            'company_name' => $request->company_name,
            'company_licenses_no' => $request->company_lisences_no, // تأكد من تعديل الاسم لو فيه خطأ
            'identity_type' => $request->identity_type,
        ]);


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
        if (!is_null($request->referred_by)) {
            $referral = ReferralCode::where('referral_code', $request->referred_by)->first();
            if (!is_null($referral)) {
                $referralUser = $referral->user();
                $activity = Activity::find(5);
                $referralUser->addExperience($activity->experience_points, $activity->name, $activity->notification);
            }
        }

        if ($request->has('photo')) {
            $lawyer->photo = saveImage($request->file('photo'), 'uploads/lawyers/personal_image/');
            $lawyer->save();
        }
        if ($request->has('logo')) {
            $lawyer->logo = saveImage($request->file('logo'), 'uploads/lawyers/logo/');
            $lawyer->save();
        }
        if ($request->has('id_file')) {
            $lawyer->id_file = saveImage($request->file('id_file'), 'uploads/lawyers/id_file/');
            $lawyer->save();
        }

        if ($request->has('cv')) {
            $lawyer->cv = saveImage($request->file('cv'), 'uploads/lawyers/cv/');
            $lawyer->save();
        }
        if ($request->has('degree_certificate')) {
            $lawyer->degree_certificate = saveImage($request->file('degree_certificate'), 'uploads/lawyers/degree_certificate/');
            $lawyer->save();
        }
        if ($request->has('company_lisences_file')) {
            $lawyer->company_lisences_file = saveImage($request->file('company_lisences_file'), 'uploads/lawyers/company_lisences_file/');
            $lawyer->save();
        }
        // dd(    $lawyer,$lawyer->additionalInfo());
        if ($request->has('sections')) {
            foreach ($request->sections as $section) {
                LawyerSections::create([
                    'account_details_id' => $lawyer->id,
                    'section_id' => $section,
                ]);
            }
        }
        if ($request->has('licence_no')) {
            foreach ($request->licence_no as $section_id => $licen_no) {
                $item = LawyerSections::where('account_details_id', $lawyer->id)->where('section_id', $section_id)->first();
                if (!is_null($item)) {
                    $item->update([
                        'licence_no' => $licen_no
                    ]);
                }
            }

            $lawyer->update([
                'has_licence_no' => 1
            ]);
        }
        if ($request->has('license_file')) {
            foreach ($request->license_file as $section_id => $license_file) {
                $item = LawyerSections::where('account_details_id', $lawyer->id)->where('section_id', $section_id)->first();
                if (!is_null($item)) {
                    $item->update([
                        'licence_file' => saveImage($license_file, 'uploads/lawyers/license_file/')
                    ]);
                }
            }
        }

        foreach ($request->languages as $language) {
            $language = Language::findOrFail($language);
            $lawyer->languages()->attach($language);
        }

        $activate_email_otp = GenerateRegistrationRandomCode(6);

        $lawyer->update([
            'activate_email_otp' => $activate_email_otp
        ]);

        $bodyMessage4 = 'لتسجيل الدخول ';
        $bodyMessage5 = env('REACT_WEB_LINK') . "/auth/signin";
        // $bodyMessage6 = 'لاستعادة كلمة المرور :';
        // $bodyMessage7 = env('REACT_WEB_LINK') . "/auth/forgetPassword?userType=lawyer";
        $bodyMessage6 = "";
        $bodyMessage7 = "";
        $bodyMessage8 = 'للتواصل والدعم الفني :';
        $bodyMessage9 = env('REACT_WEB_LINK') . "/contact-us";
        $bodyMessage10 = 'نعتز بثقتكم';
        $em_data = [
            'name' => $lawyer->name,
            'email' => $lawyer->email,
            'subject' => "رابط تأكيد البريد . ",
            'bodyMessage' => "مرحباً بك في تطبيق يمتاز , بالضغط على رابط تأكيد البريد التالي فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز واكتمال طلب التفعيل .  ",
            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
            'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmOtpLawyer?otp=' . $activate_email_otp . '&id=' . $lawyer->id,
            'bodyMessage4' => $bodyMessage4,
            'bodyMessage5' => $bodyMessage5,
            'bodyMessage6' => $bodyMessage6,
            'bodyMessage7' => $bodyMessage7,
            'bodyMessage8' => $bodyMessage8,
            'bodyMessage9' => $bodyMessage9,
            'bodyMessage10' => $bodyMessage10,
            'platformLink' => env('REACT_WEB_LINK'),

        ];

        $work_em = false;
        if ($work_em) {
        Mail::send(
            'email',
            $em_data,
            function ($message) use ($em_data) {
                $message->from('ymtaz@ymtaz.sa');
                $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
            }
        );
    }
        $referralCode = GenerateReferralCode();
        $lawyer->referralCode()->create([
            'referral_code' => $referralCode,
        ]);

        $activity = Activity::find(9);
        $lawyer->addExperience($activity->experience_points, $activity->name, $activity->notification);
        $newsletter = Newsletter::where('email', $request->email);
        if (is_null($newsletter)) {
            Newsletter::create([
                "email" => $request->email
            ]);
        }


       
        $lawyer = new LawyerShortDataResource($lawyer);
        return $this->sendResponse(true, ' ملفك الآن قيد الدراسة والاعتماد لدى يمتاز , نأمل مراجعة بريدكم الالكتروني وتأكيد التفعيل بالضغط على الرابط المرسل  ', compact('lawyer'), 200);
    }
}