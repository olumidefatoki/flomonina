<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateDispatchRequest extends FormRequest
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
            'trade' => 'required|numeric',
            'aggregator' => 'required|numeric',
            'number_of_bags' => 'required|numeric',
            'truck_number' => 'required|max:10',
            //'driver_name' => 'required|max:255',
            //'driver_phone_number' => 'required|digits:11',
            'pickup_state' => 'required|numeric',
            'destination_state' => 'required|numeric',
            'commodity' => 'required|numeric',
            'estimated_arrival_time' => 'required|date_format:Y-m-d',
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        throw new HttpResponseException($response);

    }
}
