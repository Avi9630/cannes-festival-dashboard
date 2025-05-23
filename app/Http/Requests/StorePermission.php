<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermission extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name'  =>  'required|string|max:250|unique:permissions,name'
        ];
    }
}
