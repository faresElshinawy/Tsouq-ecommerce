<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'country_id'=>'required|numeric|exists:countries,id',
            // 'city_id'=>'nullable|numeric|exists:cities,id',
            'city_spare'=>'required|min:3|max:255|unique:cities,name',
            'phone'=>'required|numeric',
            'street'=>'required|min:5|max:255',
            'building_number'=>'required|numeric',
        ];
    }
}
