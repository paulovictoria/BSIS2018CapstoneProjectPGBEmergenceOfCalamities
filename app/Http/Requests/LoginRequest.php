<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
          'email' => 'required|unique:admins|email|max:255',
          'password' => 'required|alpha_num|min:8'
        ];
    }
    public function messages()
    {
      return [
        'email.required'  => 'Email Address is required',
        'password.required'  => 'Password is required',
      ];
    }
}
