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

    public function json($data = null, array $headers = [])
    {
        return new JsonResponse($data, $this->statusCode, $headers);
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
            return $this->json();
        }

        return $this->json([
            'errors' => $messages,
        ]);
    }

    /**
     * Make a 404 error response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNotFound($message = 'Not Found')
    {
        return $this->withStatusCode(Response::HTTP_NOT_FOUND)->withError($message);
    }

    /**
     * Make a 204 JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withNoContent()
    {
        return $this->withStatusCode(Response::HTTP_NO_CONTENT)->withError();
    }

    /**
     * Make a 500 error response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withInternalServerError($message = 'Internal Server Error')
    {
        return $this->withStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->withError($message);
    }

    /**
     * Make a 401 error response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withUnauthorized($message = 'Unauthorized')
    {
        return $this->withStatusCode(Response::HTTP_UNAUTHORIZED)->withError($message);
    }
}
