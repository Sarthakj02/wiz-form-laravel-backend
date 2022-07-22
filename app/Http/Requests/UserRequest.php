<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name'    => 'required',
            'email'   => 'required|email|unique:users',
            'password'  => ['required', Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
            'hobby'    => 'required',
            'qualification'    => 'required',
            'college' => 'required',
            'cgpa'    => 'required|numeric|between:0.00,10.00',
            'phone'   => 'required|digits:10|distinct',
            'dob'     => 'required|date',
            'work_experience' => 'required|string|min:3|max:60',
        ];
    }
}
