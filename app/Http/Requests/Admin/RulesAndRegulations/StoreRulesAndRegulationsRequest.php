<?php

namespace App\Http\Requests\Admin\RulesAndRegulations;

use Illuminate\Foundation\Http\FormRequest;

class StoreRulesAndRegulationsRequest extends FormRequest
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
       $inputs = request()->all();

        return [
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'name'=>'required',
            'release_date'=>'required',
            'publication_date'=>'required',
            'status'=>'required',
            'law_name'=>'required',
            'law_description'=>'required',
            'world_file'=>array_key_exists('id',$inputs)?' sometimes' :'required',
            'pdf_file'=>array_key_exists('id',$inputs)?' sometimes' :'required',
            'about'=>'required',
            'text'=>'required',
            'release_tools.*'=>'sometimes',
            'release_tools.*.tool'=>'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required'=>'القسم الرئيسي مطلوب ',
            'sub_category_id.required'=>'القسم الفرعي مطلوب ',
            'name.required'=>'اسم مطلوب',
            'release_date.required'=>'تاريخ الإصدار مطلوب ',
            'publication_date.required'=>' مطلوب تاريخ النشر ',
            'status.required'=>'الحالة  مطلوب ',
            'law_name.required'=>' مطلوب اسم القانون',
            'law_description.required'=>' مطلوب وصف قصير القانون ',
            'world_file.required'=>' مطلوب الكتاب النسخة صيغة وورد',
            'pdf_file.required'=>' مطلوب الكتاب النسخة صيغة pdf',
            'about.required'=>' مطلوب وصف قصير ',
            'text.required'=>'نـــص النظـــام مطلوب  ',
            'release_tools.required'=>' يجب ادخال اداة نشر واحدة على الاقل ',
            'release_tools.*.tool'=>' يجب ادخال اسم اداة نشر واحدة على الاقل ',
        ];
    }
}
