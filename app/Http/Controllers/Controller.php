<?php

namespace App\Http\Controllers;

use App\Support\ResponseFactory;
use Illuminate\Validation\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * Response factory.
     *
     * @var \App\Support\ResponseFactory
     */
    protected $response;

    /**
     * Creates a new controller instance.
     *
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response)
    {
        $this->response = $response;
    }

    /**
     * Format the validation errors structure.
     *
     * @param  Validator $validator
     *
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return [
            'errors' => $validator->errors()->getMessages(),
        ];
    }
}
