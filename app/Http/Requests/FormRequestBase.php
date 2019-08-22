<?php

namespace App\Http\Requests;

use App\Constants\ExceptionConstants;
use App\Exceptions\CustomException;
use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Contracts\Validation\Validator;

class FormRequestBase extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new CustomException(ExceptionConstants::VALIDATION_INVALID_DATA, $validator->errors());
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
