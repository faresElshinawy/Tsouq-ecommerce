<?php

namespace App\Http\Requests\Api;

use Exception;
use App\Traits\Api;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiFormRequest extends FormRequest
{

    use Api;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new Exception($this->apiResponse('validation failed',null,$validator->errors(),401));
    }
}
