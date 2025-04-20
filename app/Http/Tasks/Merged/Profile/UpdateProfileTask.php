<?php

namespace App\Http\Tasks\Merged\Profile;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Activity;
use App\Models\AppTexts;
use App\Models\Language;
use App\Models\LawyerOld;
use App\Models\AccountsOtp;
use App\Http\Tasks\BaseTask;
use App\Models\Degree\Degree;
use App\Models\ServiceUserOld;
use App\Models\Lawyer\LawyerType;
use App\Models\LawyerAdditionalInfo;
use Illuminate\Support\Facades\Mail;
use App\Models\Lawyer\LawyerSections;
use App\Http\Resources\AccountResource;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\DigitalGuide\DigitalGuideCategories;

class UpdateProfileTask extends BaseTask
{

    public function run(UpdateProfileRequest $request)
    {
        $user = Account::find(auth()->user()->id);
        if ($user->account_type == "lawyer") {
            if ($request->has('languages')) {
                $missingLanguage = [];
                foreach ($request->languages as $languageId) {
                    $language = Language::find($languageId);
                    if (is_null($language)) {
                        $missingLanguage[] = "اللغة غير موجودة: $languageId";
                    }
                }
                if (count($missingLanguage) > 0) {
                    return $this->sendResponse(false, 'Validation Error', ["errors" => ["languages" => $missingLanguage]], 422);
                }
            }
            if ($request->has('type')) {
                $lawyerType = LawyerType::where('id', '=', $request->type)->first();
                if ($lawyerType->need_company_name && !$request->has('company_name')) {
                    return $this->sendResponse(false, 'اسم الشركة مطلوب', ["errors" => ["company_name" => ["اسم الشركة مطلوب"]]], 422);
                }
                if ($lawyerType->need_company_licence_no && !$request->has('company_licenses_no')) {
                    return $this->sendResponse(false, 'رقم السجل التجاري مطلوب', ["errors" => ["company_licenses_no" => ['رقم السجل التجاري مطلوب']]], 422);
                }
                if ($lawyerType->need_company_licence_file && !$request->has('company_license_file')) {
                    return $this->sendResponse(false, 'صورة ترخيص الشركة مطلوب', ["errors" => ["company_license_file" => ['صورة ترخيص الشركة مطلوب']]], 422);
                }
            }
        }
        $oldUser = Account::find(auth()->user()->id);
        $msg = "تم تعديل الحساب بنجاح";
        $phoneChanged = $request->phone != $oldUser->phone || $request->phone_code != $oldUser->phone_code;
        if ($phoneChanged) {
            if ($user->phone_code == "966") {
                $currentCode = AccountsOtp::where(['phone_code' => $request->phone_code, 'phone' => $request->phone, 'otp' => $request->otp])->first();
                if (!is_null($currentCode)) {
                    if ($currentCode->confirmed != 1) {
                        return $this->sendResponse(false, 'رمز التحقق غير مؤكد', null, 400);
                    }
                }
                $user->update([
                    'phone_confirmation' => 1,
                    'phone_otp' => null,
                    'phone_otp_expires_at' => null,
                    'phone' => $request->phone,
                    'phone_code' => $request->phone_code,
                ]);
            } else {
                $user->update([
                    'phone_confirmation' => 1,
                    'phone_otp' => null,
                    'phone_otp_expires_at' => null,
                    'phone' => $request->phone,
                    'phone_code' => $request->phone_code,
                ]);
            }
        }
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
            $user->save();
        }
        if ($request->hasFile('profile_photo')) {
            $user->profile_photo = saveImage($request->file('profile_photo'), 'uploads/account/profile_photo/');
            $user->save();
        }
        $user->update([
            "name" => $request->name ? $request->name : "",
            'email' => $request->email,
            'region_id' => $request->region_id,
            'city_id' => $request->city_id,
            'country_id' => $request->country_id,
            'nationality_id' => $request->nationality_id,
            'type' => $request->type,
            'account_type' => $request->account_type,
            'gender' => $request->gender,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude
        ]);
        if ($user->account_type == "lawyer") {
            if ($request->has('type')) {
                $lawyerType = LawyerType::where('id', '=', $request->type)->first();
                if ($lawyerType->need_company_name && !$request->has('company_name')) {
                    return $this->sendResponse(false, 'اسم الشركة مطلوب', ["errors" => ["company_name" => ["اسم الشركة مطلوب"]]], 422);
                }
                if ($lawyerType->need_company_licence_no && !$request->has('company_licenses_no')) {
                    return $this->sendResponse(false, 'رقم السجل التجاري مطلوب', ["errors" => ["company_licenses_no" => ['رقم السجل التجاري مطلوب']]], 422);
                }
                if ($lawyerType->need_company_licence_file && !$request->has('company_license_file')) {
                    return $this->sendResponse(false, 'صورة ترخيص الشركة مطلوب', ["errors" => ["company_license_file" => ['صورة ترخيص الشركة مطلوب']]], 422);
                }
            }
            $lawyer_name = implode(" ", array_filter([
                $request->first_name ?? '',
                $request->second_name ?? '',
                $request->third_name ?? '',
                $request->fourth_name ?? '',
            ]));
            $user->name = $lawyer_name;
            $user->save();
            $lawyer_data = $request->except([
                'name',
                'email',
                'phone',
                'phone_code',
                'password',
                'region_id',
                'city_id',
                'country_id',
                'type',
                'account_type',
                'profile_photo',
                'gender',
                'longitude',
                'latitude',
                'first_name',
                'second_name',
                'third_name',
                'forth_name',
                'sections',
                'other_degree',
                'degree_certificate',
                'national_id_image',
                'license_image',
                'license_no',
                'cv_file',
                'company_license_file',
                'other_identity_type',
                'logo'
            ]);
            $account_details = LawyerAdditionalInfo::where('account_id', $user->id)->first();
            $oldUserSections = $account_details->SectionsRel()->get()->toArray();
            $special_degree_certificate_check = true;
            if ($request->has('sections')) {
                $lawyer_sections_ids = LawyerSections::where('account_details_id', $account_details->id)->pluck('section_id')->toArray();
                foreach ($request->sections as $section) {
                    $item = DigitalGuideCategories::where('status', 1)->where('id', $section)->first();
                    if (!is_null(value: $item) && !in_array($item->id, $lawyer_sections_ids)) {
                        if ($item->need_license == 1) {
                            if (!is_null($request->license_no)) {
                                $check = array_key_exists($section, $request->license_no);
                            } else {
                                $check = false;
                            }

                            if ($check == false) {
                                return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها رقم الترخيص . وشكراً ', null, 422);
                            }
                            if (!is_null($request->license_image)) {
                                $check = array_key_exists($section, $request->license_image);
                            } else {
                                $check = false;
                            }

                            if ($check == false) {
                                \Log::info($check);

                                return $this->sendResponse(false, 'عذراً هناك مشكلة . انت اخترت مهنة تحتاج الى ترخيص , وهي : ' . $item->title . ' ويجب ادخال لها ملف اثيات الترخيص . وشكراً ', null, 422);
                            }
                            $special_degree_certificate_check = false;
                        }

                    }
                }
            }
            if ($request->has('degree')) {
                $degree = Degree::where('isYmtaz', 1)->findOrFail($request->degree);
                if ($degree->id != $account_details->degree) {
                    if ($degree->id == 4) {
                        if (!array_key_exists('degree_certificate', $request->all())) {
                            return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
                        }
                        $newDeg = Degree::create([
                            'title' => $request->other_degree,
                        ]);
                        $account_details->update([
                            'degree' => $newDeg->id
                        ]);
                        $account_details->save();
                    } else {
                        if ($special_degree_certificate_check) {
                            if ($degree->isSpecial) {
                                if (!array_key_exists('degree_certificate', $request->all())) {
                                    return $this->sendResponse(false, 'يجب ادخال الشهادة العلمية', ["errors" => ["degree_certificate" => 'يجب ادخال الشهادة العلمية']], 422);
                                }
                            }
                        }
                        $account_details->update([
                            'degree' => $degree->id
                        ]);
                    }
                }
            }
            if ($request->has('languages')) {
                $account_details->languages()->detach();
                foreach ($request->languages as $language) {
                    $language = Language::findOrFail($language);
                    $account_details->languages()->attach($language);
                }
            } else {
                $account_details->languages()->detach();
            }
            if ($request->has('logo')) {
                $account_details->update([
                    'logo' => saveImage($request->file('logo'), 'uploads/account/logo/')
                ]);
            }
            if ($request->has('national_id_image')) {
                $account_details->update([
                    'national_id_image' => saveImage($request->file('national_id_image'), 'uploads/account/national_id_image/')
                ]);
            }
            if ($request->has('cv_file')) {
                $account_details->update([
                    'cv_file' => saveImage($request->file('cv_file'), 'uploads/account/cv_file/')
                ]);
            }
            if ($request->has('degree_certificate')) {
                $account_details->update([
                    'degree_certificate' => saveImage($request->file('degree_certificate'), 'uploads/account/degree_certificate/')
                ]);
            }

            if ($request->has('company_license_file')) {
                $account_details->update([
                    'company_license_file' => saveImage($request->file('company_license_file'), 'uploads/account/company_license_file/')
                ]);
            }
            if ($request->has('sections')) {
                $account_details->SectionsRel()->detach();
                foreach ($request->sections as $section) {
                    $section = DigitalGuideCategories::findOrFail($section);

                    $oldSection = array_filter($oldUserSections, function ($data) use ($section) {
                        \Log::info($data);
                        return $data['id'] == $section->id;
                    });
                    \Log::info(count($oldSection));
                    if (count($oldSection) > 0) {
                        $licenceFile = $oldSection[0]['pivot']['licence_file'];
                        $account_details->SectionsRel()->attach($section, [
                            'licence_file' => $licenceFile
                        ]);
                    } else {
                        $account_details->SectionsRel()->attach($section);
                    }
                }
            }
            if ($request->has('license_no')) {
                foreach ($request->license_no as $section_id => $licen_no) {
                    $item = LawyerSections::where('account_details_id', $account_details->id)->where('section_id', $section_id)->first();
                    if (!is_null($item)) {
                        $item->update([
                            'licence_no' => $licen_no
                        ]);
                    }
                }
            }
            if ($request->has('license_image')) {
                foreach ($request->license_image as $section_id => $license_image) {
                    $item = LawyerSections::where('account_details_id', $account_details->id)->where('section_id', $section_id)->first();
                    if (!is_null($item) && $request->license_image) {
                        $item->update([
                            'licence_file' => saveImage($license_image, 'uploads/account/license_image/')
                        ]);
                    }
                }
            }

            $account_details->update($lawyer_data);
        }
        $emailChanged = $request->email != $oldUser->email;
        if ($oldUser->status == 2) {
            if ($emailChanged) {
                $key = GenerateRegistrationRandomCode(6);
                $user->update([
                    'email_confirmation' => 0,
                    'email_otp' => $key,
                    'email_otp_expires_at' => now()->addMinutes(10)
                ]);
                if ($emailChanged) {
                    $bodyMessage3 = '';
                    $bodyMessage4 = '';
                    $bodyMessage5 = '';
                    $bodyMessage6 = '';
                    $bodyMessage7 = 'للتواصل والدعم الفني :';
                    $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
                    $bodyMessage9 = '';
                    $bodyMessage10 = 'نعتز بثقتكم';
                    $bodyMessage = nl2br(AppTexts::where('key', 'email-otp-message')->first()->value);

                    $em_data = [
                        'name' => $user->name,
                        'email' => $user->email,
                        'subject' => " كود تفعيل الحساب . ",
                        'bodyMessage' => $bodyMessage,
                        'bodyMessage1' => $key,
                        'bodyMessage2' => " ",
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
                        $em_data,
                        function ($message) use ($em_data) {
                            $message->from('ymtaz@ymtaz.sa');
                            $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                        }
                    );
                    $msg = 'تم ارسال رمز التفعيل على بريدكم الإلكتروني بنجاح
        قم بإدخال الرمز المرسل على البريد.';
                }
            }

        } else if ($user->status == 3) {
            if ($user->email_confirmation != 1) {

                $key = GenerateRegistrationRandomCode(6);
                $bodyMessage3 = '';
                $bodyMessage4 = '';
                $bodyMessage5 = '';
                $bodyMessage6 = '';
                $bodyMessage7 = 'للتواصل والدعم الفني :';
                $bodyMessage8 = env('REACT_WEB_LINK') . "/contact-us";
                $bodyMessage9 = '';
                $bodyMessage10 = 'نعتز بثقتكم';
                $bodyMessage = nl2br(AppTexts::where('key', 'confirm-email-link')->first()->value);

                $em_data = [
                    'name' => $user->name,
                    'email' => $user->email,
                    'subject' => "رابط تأكيد البريد . ",
                    'bodyMessage' => $bodyMessage,
                    'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                    'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                    'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&id=' . $user->id . '&type=account',
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
                    $em_data,
                    function ($message) use ($em_data) {
                        $message->from('ymtaz@ymtaz.sa');
                        $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                    }
                );
                $user->update([
                    'email_confirmation' => 0,
                    'email_otp' => $key,
                    'email_otp_expires_at' => now()->addMinutes(10),
                ]);
                $msg = 'تم ارسال رابط التفعيل على بريدكم الإلكتروني بنجاح
    بالضغط على رابط التفعيل المرسل فأنت تؤكد اكتمال بيانات حسابكم لدى يمتاز.';
            }
        }
        if ($user->account_type == "lawyer") {
            $user->update([
                'status' => 1
            ]);
        }
        $oldUser = LawyerOld::where('email', $request->email)->orWhere(function ($query) use ($request) {
            $query->where('phone', $request->phone)
                ->where('phone_code', $request->phone_code);
        })->first();
        if (!is_null($oldUser)) {
            if ($oldUser->accepted == 0) {
                $oldUser->update([
                    'accepted' => 1
                ]);
            }
        } else {
            $oldUser = ServiceUserOld::where('email', $request->email)->orWhere(function ($query) use ($request) {
                $query->where('mobil', $request->phone)
                    ->where('phone_code', $request->phone_code);
            })->first();
            if (!is_null($oldUser)) {
                if ($oldUser->accepted == 0) {
                    $oldUser->update([
                        'accepted' => 1
                    ]);
                }
            }
        }

        if ($user->profile_complete != 1) {
            $user->update([
                'profile_complete' => 1,
                'status' => $user->account_type == "lawyer" ? 1 : 2
            ]);
            $activity = Activity::find(2);
            $user->clientGamification()->addExperience($activity->experience_points, $activity->name, $activity->notification);
            $bodyMessage4 = 'كما نسعد بتلقي اقتراحاتكم وملاحظاتكم عبر أيقونة اتصل بنا .';
            $bodyMessage5 = '';
            $bodyMessage6 = '';
            $bodyMessage7 = '';
            $bodyMessage8 = '';
            $bodyMessage9 = '';
            $bodyMessage10 = 'وتقبلوا تحياتنا.';
            $bodyMessage1 = nl2br(AppTexts::where('key', 'completed-profile-email-message')->first()->value);
            $em_data = [
                'name' => $user->name,
                'email' => $user->email,
                'subject' => "رابط تأكيد البريد . ",
                'bodyMessage' => "تهانينا شريكنا العزيز .",
                'bodyMessage1' => $bodyMessage1,
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
                $em_data,
                function ($message) use ($em_data) {
                    $message->from('ymtaz@ymtaz.sa');
                    $message->to($em_data['email'], $em_data['name'])->subject($em_data['subject']);
                }
            );
        }
        $user = Account::find(auth()->user()->id);
        $account = new AccountResource($user);
        return $this->sendResponse(true, $msg, compact('account'), 200);
    }
}
