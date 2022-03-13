<?php

namespace App\Http\Requests;

use App\Rules\DecimalValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePurcharseRequest extends FormRequest
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
            'dispatch' => 'required|numeric',
            'processor' => 'required|numeric',
            'accepted_quantity' => ['required', new DecimalValidator()],
            'aggregator_price' => ['required', new DecimalValidator()],
            'discounted_price' => ['required', new DecimalValidator()],
            'processor_price' => ['required', new DecimalValidator()],
            'way_ticket' => 'required|image|mimes:jpeg,png,jpg,gif|max:1048',
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        throw new HttpResponseException($response);

    }
}
