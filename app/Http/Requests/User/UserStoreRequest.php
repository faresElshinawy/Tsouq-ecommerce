<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'=>'required|min:3|unique:users,name',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|max:20|min:8|confirmed|regex:/[a-z]/|regex:/[A-Z]/|',
            'roles'=>'required|exists:roles,name',
            'image'=>'nullable|image|mimes:jpeg,jpg,png,gif|max:3000'
        ];
    }
}
