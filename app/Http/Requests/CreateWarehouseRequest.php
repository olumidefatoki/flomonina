<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateWarehouseRequest extends FormRequest
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
            'state' => 'required|numeric',
            'lga' => 'required|numeric',
            'name' => 'required|max:255|unique:warehouse',
            'address' => 'required|max:255',
        ];
    }

    public function failedValidation($validator)
    {
        $response = response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        throw new HttpResponseException($response);

    }
}
