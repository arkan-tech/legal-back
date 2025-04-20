<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWorkingHoursRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth()->guard('api_lawyer')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'days' => 'required|array',
            'days.*.dayOfWeek' => 'required|integer|min:0|max:6',
            'days.*.timeSlots' => 'required|array',
            'days.*.timeSlots.*.from' => 'required|date_format:H:i',
            'days.*.timeSlots.*.to' => 'required|date_format:H:i|after:days.*.timeSlots.*.from',
            'days.*.timeSlots.*.minsBetween' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'days.*.dayOfWeek.required' => 'The day of the week is required.',
            'days.*.dayOfWeek.integer' => 'The day of the week must be an integer.',
            'days.*.dayOfWeek.min' => 'The day of the week must be at least 1.',
            'days.*.dayOfWeek.max' => 'The day of the week may not be greater than 7.',
            'days.*.timeSlot.*.from.required' => 'The start time is required.',
            'days.*.timeSlot.*.from.date_format' => 'The start time must be in the format HH:MM.',
            'days.*.timeSlot.*.to.required' => 'The end time is required.',
            'days.*.timeSlot.*.to.date_format' => 'The end time must be in the format HH:MM.',
            'days.*.timeSlot.*.to.after' => 'The end time must be after the start time.',
            'days.*.timeSlot.*.minsBetween.required' => 'The minutes between slots is required.',
            'days.*.timeSlot.*.minsBetween.integer' => 'The minutes between slots must be an integer.',
        ];
    }
}
