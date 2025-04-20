<?php

namespace App\Http\Requests\API\Lawyer\Services;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class LawyerReplyServicesRequestsRequest extends BaseRequest
{
    public function authorize()
    {
        // Authorization logic here
        return true;
    }

    public function rules()
    {
        return [
            'request_id' => 'required|exists:services_reservations,id',
            // 'reply_subject' => 'required|string|max:255',
            'reply_content' => 'required|string',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];
    }
}
