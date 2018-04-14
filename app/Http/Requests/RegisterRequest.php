<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
          'name' => 'required|max:255|unique:admins',
          'email' => 'required|unique:admins|email|max:255',
          'usercontact' => ['required', 'regex:/^(09|\+639)\d{9}$/'],
          'municipality' => 'required|unique:admins',
          'password' => 'required|alpha_num|min:8',
          'municipalAddress' => 'required|min:15'
        ];
    }
    public function messages()
    {
      return [
        'name.required' => 'Name is required',
        'email.required'  => 'Email Address is required',
        'usercontact.required'  => 'Contact Number is required',
        'municipality.required'  => 'Municipality is required',
        'password.required'  => 'Password is required',
        'municipalAddress.required'  => 'Municipal Address is required',
      ];
    }
}
