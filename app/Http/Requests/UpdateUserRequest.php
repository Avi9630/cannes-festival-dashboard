<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"                  =>  "required",
            'email'                 =>  'required|unique:users,email,'.$this->user->id,
            // "email"                 =>  "required|unique:users",
            'mobile'                =>  'required|unique:users,mobile,'.$this->user->id,
            // "mobile"                =>  "required|unique:users",
            "usertype"              =>  "required|integer",
            "password"              =>  "required|min:5",
            "password_confirmation" =>  "required|same:password",
        ];
    }
}
