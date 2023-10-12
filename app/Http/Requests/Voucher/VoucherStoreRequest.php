<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class VoucherStoreRequest extends FormRequest
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
            'code'=>'required|min:2|max:255|regex:/[A-Z]/|regex:/[1-10]/|unique:vouchers,code',
            'value'=>'required|numeric',
            'price_limit'=>'required|numeric',
            'type'=>'required|in:percentage,row_discount',
            'status'=>'required|in:active,inactive'
        ];
    }
}
