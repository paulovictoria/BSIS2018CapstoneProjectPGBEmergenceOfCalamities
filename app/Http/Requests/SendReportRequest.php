<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendReportRequest extends FormRequest
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
            'fullName' => 'required',
            'address' => 'required',
            'contactNumber' => 'nullable',
            'landline' => 'nullable',
            'landmark' => 'required',
            'type' => 'required',
            'municipality' => 'required',
            'image' => 'mimes:jpeg,jpg,png|nullable'
        ];
    }

    public function messages() {
        return [
            'fullName.required' => 'The name is required',
            'address.required' => 'The address is required',
            'landmark.required' => 'The landmark is required',
            'contactNumber.required' => 'The contact number is required',
            'type.required' => 'The rescue type is required',
            'municipality' => 'The municipality is required'
        ];
    }
}
