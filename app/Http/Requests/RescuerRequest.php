<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RescuerRequest extends FormRequest
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
            'rescuerName' => 'required',
            'assignRoute' => 'required',
            'password' => 'required|confirmed|unique:geolocations|alpha_num|min:8',
            'municipality' => 'required'

        ];
    }

    public function messages()
    {
      return [
        'rescuerName.required' => 'The rescuer name is required',
        'assignRoute.required' => 'The assigned route is required',
        'password.required' => 'The password is required',
        'municipality.required' => 'The municipality is required'
      ];
    }
}
