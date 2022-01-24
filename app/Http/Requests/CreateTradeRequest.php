<?php

namespace App\Http\Requests;

use App\Rules\DecimalValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTradeRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'partner' => 'required|numeric',
            'type' => 'required',
            'quantity' => ['required', new DecimalValidator()],
            'margin' => ['required', new DecimalValidator()],
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        throw new HttpResponseException($response);
    }
}
