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
     * @param  string|null ...$messages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withError(...$messages)
    {
        if (! $messages) {
            return new JsonResponse(null, $this->statusCode);
        }

        return new JsonResponse([
            'errors' => $messages,
        ], $this->statusCode);
    }

    /**
     * Make a 404 error response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNotFound($message = 'Not found')
    {
        return $this->withStatusCode(Response::HTTP_NOT_FOUND)->withError($message);
    }

    /**
     * Make a 204 error response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent()
    {
        return $this->withStatusCode(Response::HTTP_NO_CONTENT)->withError();
    }
}
