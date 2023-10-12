<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name'=>'required|min:3|unique:users,name,' . $this->user->id,
            'email'=>'required|email|unique:users,email,' . $this->user->id,
            'password'=>'nullable|max:20|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
            'roles'=>'required|exists:roles,name',
            'image'=>'nullable|image|mimes:jpeg,jpg,png,gif|max:3000'
        ];
    }
}
