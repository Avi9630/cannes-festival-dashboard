<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            "dob"           =>  "required|date_format:Y-m-d|before:today",
            "image"         =>  "nullable|image|mimes:jpeg,jpg,png,gif",
            "designation"   =>  "required",
            "pan_number"    =>  "required",
            "address"       =>  "required",
            "state_id"      =>  "required|numeric",
            "city_id"       =>  "required|numeric",
            "pincode"       =>  "required",
            "gst_number"    =>  "required",
        ];
    }
}
