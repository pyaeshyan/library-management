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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required|string|min:8'
        ];
    }

    public function messages()
    {
        return[
            'emial.required' => 'Email is required',
            'password.required' => 'Password is required',
            'password.string' => 'Password should be string',
            'password.min' => 'Password should be 8 character long'
        ];
    }
}
