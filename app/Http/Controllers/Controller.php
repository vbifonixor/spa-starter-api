<?php

namespace App\Http\Controllers;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Support\ResponseFactory;
use App\Support\QueryParameterBag;
use App\Support\TransformerHandler;
use Illuminate\Validation\Validator;
use League\Fractal\Serializer\DataArraySerializer;
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
     * Transformer handler.
     *
     * @var \App\Support\TransformerHandler
     */
    protected $transform;

    /**
     * Creates a new controller instance.
     *
     * @param ResponseFactory $response
     */
    public function __construct(Request $request, ResponseFactory $response, QueryParameterBag $parameters)
    {
        $fractal = new Manager;
        $serializer = new DataArraySerializer;

        if ($request->has('include')) {
            $fractal->parseIncludes($request->query('include'));
        }

        $this->parameters = $parameters;
        $this->transform = new TransformerHandler($fractal, $serializer);

        $this->response = $response;
        $this->response->setTransformerHandler($this->transform);

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
