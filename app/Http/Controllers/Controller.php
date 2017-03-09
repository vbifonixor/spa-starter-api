<?php

namespace App\Http\Controllers;

use App\Support\ResponseFactory;
use App\Support\QueryParameterBag;
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
     * Query parameters bag.
     *
     * @var \App\Support\QueryParameterBag
     */
    protected $parameters;

    /**
     * Creates a new controller instance.
     *
     * @param ResponseFactory $response
     */
    public function __construct(ResponseFactory $response, QueryParameterBag $parameters)
    {
        $this->response = $response;
        $this->parameters = $parameters;
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
