<?php

namespace App\Http\Tasks\Merged\Auth;

use App\Models\AppTexts;
use App\Http\Tasks\BaseTask;
use Illuminate\Http\Request;
use App\Models\Lawyer\Lawyer;
use App\Models\Service\ServiceUser;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\API\Client\ClientDataResource;
use App\Http\Resources\API\Lawyer\LawyerShortDataResource;

class ConfirmOtp extends BaseTask
{
    public function run(Request $request)
    {
        $user = auth()->user();
        $oldUser = auth()->user();
        $reserverType = "lawyer";
        if (auth()->guard('api_lawyer')->check()) {
            $user = Lawyer::find($user->id);
        }
        if (auth()->guard('api_client')->check()) {
            $reserverType = "client";
            $user = ServiceUser::find($user->id);
        }
        // $confirmationType = $request->confirmationType;
        // if ($confirmationType == 1) {
        if (!is_null($user->confirmationType)) {
            \Log::info("Changing otp");
            if ($user->confirmationOtp != $request->otp) {
                return $this->sendResponse(false, 'الرمز خطأ', null, 400);
            }

            if ($reserverType == "lawyer") {
                if ($oldUser->accepted == 2) {

                    $msg = $oldUser->confirmationType == "phone" ? $oldUser->changedBoth == true ? "تم تأكيد رقم الجوال بنجاح
نأمل منكم تأكيد اكتمال بيانات حسابكم لدى يمتاز بالضغط على رابط التفعيل المرسل لكم على بريدكم الإلكتروني" : "تم تأكيد رقم الجوال بنجاح" : "تم تأكيد البريد الإلكتروني بنجاح";

                    if ($oldUser->changedBoth == true) {
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
                            'name' => $user->myname,
                            'email' => $user->email,
                            'subject' => "رابط تأكيد البريد . ",
                            'bodyMessage' => $bodyMessage,
                            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                            'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&type=lawyer' . '&id=' . $user->id,
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
                            'confirmationOtp' => $key,
                            'confirmationType' => "email",
                            "changedBoth" => null
                        ]);
                    } else {
                        $user->update([
                            'confirmationOtp' => null,
                            'confirmationType' => null,
                            'accepted' => 1,
                        ]);
                    }
                } else if ($oldUser->accepted == 3) {
                    if ($oldUser->confirmationType == "phone") {
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
                            'name' => $user->myname,
                            'email' => $user->email,
                            'subject' => "رابط تأكيد البريد . ",
                            'bodyMessage' => $bodyMessage,
                            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                            'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&type=lawyer' . '&id=' . $user->id,
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
                            'confirmationType' => 'email',
                            'confirmationOtp' => $key
                        ]);
                        $msg = "تم تأكيد رقم الجوال بنجاح
نأمل منكم تأكيد اكتمال بيانات حسابكم لدى يمتاز بالضغط على رابط التفعيل المرسل لكم على بريدكم الإلكتروني";
                    } else if ($oldUser->confirmationType == "email") {
                        $user->update([
                            'confirmationOtp' => null,
                            'confirmationType' => null,
                            'accepted' => 1,
                        ]);
                        $msg = "تم تأكيد البريد الإلكتروني بنجاح";
                    }
                }
                $user = new LawyerShortDataResource($user);
            } else {
                if ($oldUser->accepted == 2) {
                    \Log::info('accepted 2');

                    $msg = $oldUser->confirmationType == "phone" ? $oldUser->changedBoth == true ? "تم تأكيد رقم الجوال بنجاح
نأمل منكم تأكيد اكتمال بيانات حسابكم لدى يمتاز بالضغط على رابط التفعيل المرسل لكم على بريدكم الإلكتروني" : "تم تأكيد رقم الجوال بنجاح" : "تم تأكيد البريد الإلكتروني بنجاح";

                    if ($oldUser->changedBoth == true) {
                        \Log::info('changed both');
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
                            'name' => $user->myname,
                            'email' => $user->email,
                            'subject' => "رابط تأكيد البريد . ",
                            'bodyMessage' => $bodyMessage,
                            'bodyMessage1' => 'ملاحظة  مهمة : يتم استخدام الرابط مرة واحدة فقط . ',
                            'bodyMessage2' => " يرجى اتباع الرابط للتأكيد : ",
                            'bodyMessage3' => env('REACT_WEB_LINK') . '/auth/confirmEmail?otp=' . $key . '&type=client' . '&id=' . $user->id,
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
                            'confirmationOtp' => $key,
                            'confirmationType' => "email",
                            "changedBoth" => null
                        ]);
                    } else {
                        \Log::info('changed one or added email after changed 2');
                        $user->update([
                            'confirmationOtp' => null,
                            'confirmationType' => null,
                            'accepted' => 2,
                        ]);
                    }
                } else if ($oldUser->accepted == 3) {
                    if ($oldUser->confirmationType == "phone") {
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
                            'name' => $user->myname,
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
                            'confirmationType' => 'email',
                            'confirmationOtp' => $key
                        ]);
                        $msg = "تم تأكيد رقم الجوال بنجاح
نأمل منكم تأكيد اكتمال بيانات حسابكم لدى يمتاز بالضغط على رابط التفعيل المرسل لكم على بريدكم الإلكتروني";
                    } else if ($oldUser->confirmationType == "email") {
                        $user->update([
                            'confirmationOtp' => null,
                            'confirmationType' => null,
                            'accepted' => 2,
                        ]);
                        $msg = "تم تأكيد البريد الإلكتروني بنجاح";
                    }
                }
                $user = new ClientDataResource($user);
            }
            return $this->sendResponse(
                true,
                $msg,
                $user,
                200,
            );
        } else {
            return $this->sendResponse(false, 'تم تأكيد الحساب بالفعل', null, 400);
        }
        // } else {
        //     if ($reserverType == "lawyer") {
        //         if ($user->activate_email_otp) {
        //             if ($user->activate_email_otp != $request->otp) {
        //                 return $this->sendResponse(false, 'الرمز خطأ', null, 400);
        //             }
        //             $user->update([
        //                 'activate_email_otp' => null,
        //             ]);
        //             $user = new LawyerShortDataResource($user);
        //             return $this->sendResponse(
        //                 true,
        //                 'OTP confirmed successfully',
        //                 $user,
        //                 200,
        //             );
        //         } else {
        //             return $this->sendResponse(false, 'تم تأكيد الحساب بالفعل', null, 400);
        //         }
        //     } else {
        //         if ($user->active == 1) {
        //             return $this->sendResponse(
        //                 true,
        //                 "الحساب مفعل بالفعل",
        //                 null,
        //                 400
        //             );
        //         } else {
        //             if ($user->active_otp != $request->otp_code) {
        //                 return $this->sendResponse(
        //                     true,
        //                     'الكود غير صحيح',
        //                     null,
        //                     400
        //                 );
        //             } else {
        //                 $user->active_otp = null;
        //                 $user->active = 1;
        //                 $user->accepted = 2;
        //                 $user->save();
        //                 return $this->sendResponse(
        //                     true,
        //                     'OTP confirmed successfully',
        //                     $user,
        //                     200,
        //                 );
        //             }
        //         }
        //     }
        // }
    }
}
