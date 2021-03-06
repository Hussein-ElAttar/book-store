<?php

namespace App\Http\Requests\User;

use App\Http\Requests\FormRequestBase;

class storeUserRequest extends FormRequestBase
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'unique:users|required|string',
            'email'    => 'unique:users|required|string',
            'password' => 'required|string',
        ];
    }
}
