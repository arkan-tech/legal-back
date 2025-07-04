<?php

namespace App\Http\Requests\API\Lawyer\Profile;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LawyerDeleteAccountRequestRequest extends BaseRequest
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
        return [
            'delete_reason'=>'required',
            'development_proposal'=>'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'delete_reason.required'=>'يجب ادخال سبب الحذف ',

        ]; // TODO: Change the autogenerated stub
    }
}
