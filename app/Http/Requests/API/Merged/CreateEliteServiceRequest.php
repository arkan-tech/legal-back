<?php

namespace App\Http\Requests\API\Merged;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateEliteServiceRequest extends BaseRequest
{

    /**
     * Get the validqation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "elite_service_category_id" => "required|exists:elite_service_categories,id",
            "description" => "required",
            'files' => 'sometimes',
            "files.*.file" => "required|file",
            "files.*.is_voice" => "required",
        ];
    }

    public function messages()
    {
        // Custom validation messages in arabic
        return [
            'elite_service_category_id.required' => 'حقل نوع الخدمة مطلوب.',
            'elite_service_category_id.exists' => 'نوع الخدمة المحددة غير موجودة.',
            'description.required' => 'حقل الوصف مطلوب.',
            'files.*.file.required' => 'حقل الملف مطلوب.',
            'files.*.file.file' => 'يجب أن يكون الملف ملفًا صالحًا.',
            'files.*.is_voice.required' => 'حقل هل هو صوت مطلوب.',
        ];
    }
}
