<?php


namespace App\Http\Requests\API;


use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = $validator->errors();

        $response = new \Illuminate\Http\JsonResponse([
            'status' => false,
            'code' => 422,
            'message' => 'invalid_data',
            'data' => compact('errors')
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
