<?php

namespace App\Http\Requests\Site\Client\Auth;

use App\Models\Lawyer\Lawyer;
use App\Models\Country\Country;
use Illuminate\Validation\Rule;
use App\Models\Service\ServiceUser;
use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request = request()->all();
        $u_id = request()->get('id');
        $phone_code = request()->get('phone_code');
        $country = Country::where('id', $request['country_id'])->first();
        $check_required = 'sometimes';
        $check_digits = 'digits:10';
        if ($country->phone_code == 966) {
            $check_required = 'required';
        }
        if ($request['phone_code'] == 966) {
            $check_digits = 'digits:9';

        }
        // 'email' => [
//                 'required',
//                 'email',
//                 function ($attribute, $value, $fail) use ($u_id) {
//                     // Rule::unique('lawyers', 'email')->ignore($u_id)->whereNull('deleted_at')
//                     $lawyerExists = Lawyer::where('email', $value)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();
//                     $clientExists = ServiceUser::where('email', $value)->whereNull('deleted_at')->exists();

        //                     if ($lawyerExists || $clientExists) {
//                         $fail('البريد الإلكتروني موجود مسبقا');
//                     }
//                 }
//             ],
//             'phone' => [
//                 'required_if:accepted,2',
//                 function ($attribute, $value, $fail) use ($u_id, $phone_code) {
//                     $lawyerExists = Lawyer::where('phone', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();
//                     $clientExists = ServiceUser::where('mobil', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->exists();

        //                     if ($lawyerExists || $clientExists) {
//                         $fail('هذا الرقم موجود مسبقا');
//                     }
//                 }
//             ],
        return [
            'myname' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'phone_code' => 'required',
            'mobile' => [
                'required',
                $check_digits,
                'numeric',
                function ($attribute, $value, $fail) use ($u_id, $phone_code) {
                    $lawyerExists = Lawyer::where('phone', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->exists();
                    $clientExists = ServiceUser::where('mobil', $value)->where('phone_code', $phone_code)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();

                    if ($lawyerExists || $clientExists) {
                        $fail('هذا الرقم موجود مسبقا');
                    }
                }
            ],
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($u_id) {
                    $lawyerExists = Lawyer::where('email', $value)->whereNull('deleted_at')->exists();
                    $clientExists = ServiceUser::where('email', $value)->whereNull('deleted_at')->where('id', '!=', $u_id)->exists();

                    if ($lawyerExists || $clientExists) {
                        $fail('البريد الإلكتروني موجود مسبقا');
                    }
                }
            ],
            'country_id' => 'required',
            'region_id' => $check_required,
            'city' => $check_required,
            'longitude' => 'sometimes',
            'latitude' => 'sometimes',
            'nationality_id' => 'sometimes',
            'password' => 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'myname.required' => 'الاسم مطلوب',
            'gender.required' => 'الجنس مطلوب',
            'type.required' => 'الحقل مطلوب',
            'phone_code.required' => 'الحقل مطلوب',
            'region_id.required' => 'الحقل مطلوب',
            'city_id.required' => 'الحقل مطلوب',
            'longitude.required' => 'الحقل مطلوب',
            'latitude.required' => 'الحقل مطلوب',
            'password.required' => 'الحقل مطلوب',

            'email.required' => 'الحقل مطلوب ',
            'email.email' => 'يرجى ادخال ايميل صحيح   ',
            'email.unique' => 'الايميل موجود بالفعل ',

            'mobile.required' => 'الحقل مطلوب ',
            'mobile.numeric' => 'يرجى ادخال رقم جوال صحيح   ',
            'mobile.unique' => 'رقم الجوال موجود بالفعل ',
            'mobile.digits' => 'يجب اراجعة خانات رقم الجوال ',
        ]; // TODO: Change the autogenerated stub
    }
}
