<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"                  =>  "required",
            "email"                 =>  "required|unique:users",
            "mobile"                =>  "required|unique:users",
            "usertype"              =>  "required|integer",
            "password"              =>  "required|min:5",
            "password_confirmation" =>  "required|same:password",
        ];
    }
}
