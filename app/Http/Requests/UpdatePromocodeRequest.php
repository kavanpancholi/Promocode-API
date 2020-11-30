<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromocodeRequest extends FormRequest
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
            'title' => 'required|string',
            'code' => 'required','string','unique:promocodes,code,'.$this->promocode->id,
            'description' => 'string',
            'radius' => 'required|numeric|min:1',
            'radius_unit' => 'required|in:km,mile',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
        ];
    }
}
