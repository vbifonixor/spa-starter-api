<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

abstract class BaseRequest extends FormRequest
{
    /**
     * Handle the errors output format.
     *
     * @param  Validator $validator
     *
     * @return array
     */
    protected function formatErrors(Validator $validator)
    {
        return [
            'errors' => $validator->errors()->all(),
        ];
    }
}
