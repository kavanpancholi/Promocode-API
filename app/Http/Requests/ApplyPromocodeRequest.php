<?php

namespace App\Http\Requests;

use App\Rules\PromocodeValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApplyPromocodeRequest extends FormRequest
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
            'origin_latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'origin_longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'destination_latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'destination_longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'code' => ['required', 'string', new PromocodeValidationRule()],
        ];
    }

    public function messages()
    {
        return [
            'origin_latitude.regex' => 'Origin Latitude is not in correct format',
            'origin_longitude.regex' => 'Origin Longitude is not in correct format',
            'destination_latitude.regex' => 'Destination Latitude is not in correct format',
            'destination_longitude.regex' => 'Destination Longitude is not in correct format',
        ];
    }

}
