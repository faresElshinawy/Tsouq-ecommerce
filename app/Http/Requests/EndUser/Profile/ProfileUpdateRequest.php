<?php

namespace App\Http\Requests\EndUser\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|min:3|max:255|unique:users,name,' . auth()->user()->id,
            'email'=>'required|email|unique:users,email,' . auth()->user()->id,
            'password'=>'nullable|confirmed|min:8|max20'
        ];
    }
}
