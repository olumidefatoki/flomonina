<?php

namespace App\Http\Requests;

use App\Rules\DecimalValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateWarehouseDeliveryRequest extends FormRequest
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
            'number_of_bags' => 'required|numeric',
            'aggregator' => 'required|numeric',
            'commodity' => 'required|numeric',
            'warehouse' => 'required|numeric',
            'quantity' => ['required', new DecimalValidator()],
            'aggregator_price' => ['required', new DecimalValidator()],
            'partner_price' => ['required', new DecimalValidator()],
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        throw new HttpResponseException($response);
    }
}
