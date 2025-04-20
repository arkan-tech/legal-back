<?php

namespace App\Http\Requests\Site\Lawyer\Profile;

use App\Models\Country\Country;
use App\Models\Degree\Degree;
use App\Models\DigitalGuide\DigitalGuideCategories;
use App\Models\Lawyer\Lawyer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateRegisterSiteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $request = request()->all();
        $u_id = request()->get('id');
        $lawyer = Lawyer::findOrFail($u_id);
        $type = [2, 3];
        $type2 = [4, 5];
        $check_type_required = in_array($request['type'], $type) ? 'required_if:accepted,2' : 'sometimes';
        $check_type_required2 = in_array($request['type'], $type2) ? 'required_if:accepted,2' : 'sometimes';
        if (array_key_exists('degree', $request)) {
            $degree = Degree::where('id', $request['degree'])->first();
            $check_degree_need_certificate = false;
            if (!is_null($degree)) {
                if ($degree->need_certificate == 1) {
                    $check_degree_need_certificate = true;
                }
            }
        }
        if (array_key_exists('country_id', $request)) {
            $country = Country::where('id', $request['country_id'])->first();
            $check_country_status = false;
            if (!is_null($country)) {
                if ($country->phone_code == 966) {
                    $check_country_status = true;
                }
            }
        }
        $lawyer_cv = is_null($lawyer->cv) &&$lawyer->type == 1 ?'required_if:accepted,2|required_if:type,1':'sometimes';
        $lawyer_id_file = is_null($lawyer->id_file)?'required_if:type,1|required_if:accepted,2':'sometimes';
        $lawyer_company_lisences_file = is_null($lawyer->company_lisences_file) && in_array($request['type'], $type) ?'required_if:accepted,2':'sometimes';


        return [
            //            first page
            'fname' => 'required',
            'sname' => 'required',
            'tname' => 'sometimes',
            'fourthname' => 'required',
            'email' => ['required', 'email', Rule::unique('lawyers','email')->ignore($u_id)->whereNull('deleted_at')],
            'phone' => ['required',Rule::unique('lawyers','phone')->ignore($u_id)->whereNull('deleted_at')],
            'phone_code' => 'required_if:accepted,2',
            'password' => 'sometimes',
            //            second page
            'about' => 'required',
            'gender' => 'required|in:Male,Female',
            'degree' => 'required|numeric|exists:degrees,id',
            'degree_certificate' =>  'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'general_specialty' => 'required|numeric|exists:general_specialty,id',
            'accurate_specialty' => 'required|numeric|exists:accurate_specialty,id',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',



            //            third page
            'nationality' => 'required|numeric|exists:nationalities,id',
            'country_id' => 'required|numeric|exists:countries,id',
            'region' => $check_country_status ? 'required' : 'sometimes' ,
            'city' => $check_country_status ? 'required' : 'sometimes' ,
            'lat' => 'sometimes',
            'lon' => 'sometimes',

            //            fourth page
            'type' => 'required|numeric|exists:lawyer_types,id',
            'identity_type' => 'required|numeric|in:1,2,3,4',
            //            يجب التحقق من ان يكون ارقام فقط في حال كانت نوع الهوية هوية شخصية وغير هيك يكون ارقام واحرف
            'nat_id' => 'required',
            'functional_cases' => 'required|numeric|exists:functional_cases,id',


            'photo' => 'sometimes|mimes:png,jpg,jpeg,PNG,JPG,JPEG',
            'logo' => ['sometimes', 'mimes:png,jpg,jpeg,PNG,JPG,JPEG'],
            'cv' => $lawyer_cv.'|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'id_file' => $lawyer_id_file.'|mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf',
            'company_lisences_no' => [$check_type_required],
            'company_lisences_file' => [$lawyer_company_lisences_file, 'mimes:png,jpg,jpeg,PNG,JPG,JPEG,pdf'],
            'company_name' => [$check_type_required2],

        ];
    }

}



