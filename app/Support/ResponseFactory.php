<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseFactory
{
    /**
     * HTTP status code.
     *
     * @var integer
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Set the response HTTP status code.
     *
     * @param  integer $code
     *
     * @return self
     */
    public function withStatusCode($code)
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * Get the HTTP status code.
     *
     * @return integer
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Make a JSON error response.
     *
     * @param  string ...$messages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError(...$messages)
    {
        return new JsonResponse([
            'errors' => $messages,
        ], $this->statusCode);
    }
}
