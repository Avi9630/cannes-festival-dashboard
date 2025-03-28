<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  =>  ['required', 'string'],
            'email'                 =>  ['required', 'unique:users'],
            'mobile'                =>  ['required', 'unique:users'],
            'password'              =>  ['required', 'min:5'],
            'password_confirmation' =>  ['required', 'same:password']
        ];
    }
}
