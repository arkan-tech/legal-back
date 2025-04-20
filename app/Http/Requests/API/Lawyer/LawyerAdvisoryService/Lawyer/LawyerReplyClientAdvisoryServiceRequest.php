<?php

namespace App\Http\Requests\API\Lawyer\LawyerAdvisoryService\Lawyer;

use Illuminate\Foundation\Http\FormRequest;

class LawyerReplyClientAdvisoryServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:advisory_services_reservations,id',
            'reply_subject' => 'required|string',
            'reply_content' => 'required|string',
            'files.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'voice_file' => 'sometimes|mimes:mp3,wav,m4a',
        ];
    }
}
