<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name'=>'required|min:3|max:255|unique:products,name',
            'description'=>'required|min:10|max:300',
            'price'=>'required|numeric',
            'count'=>'required|numeric',
            'discount'=>'nullable|numeric',
            'category_id'=>'required|numeric|exists:categories,id',
            'brand_id'=>'nullable|numeric|exists:brands,id',
            'image'=>'required|mimes:png,jpg,jpeg,gif|image|max:3000',
            'status'=>'nullable|in:active,pending',
            'color'=>'required|array|exists:colors,id',
            'size'=>'required|array|exists:sizes,id'
        ];
    }
}
