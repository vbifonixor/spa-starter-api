<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use League\Fractal\TransformerAbstract;
use App\Support\Contracts\TransformerHandler;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResponseFactory
{
    /**
     * Transformer handler.
     *
     * @var \App\Support\Contracts\TransformerHandler
     */
    protected $transformer;

    /**
     * HTTP status code.
     *
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * Sets the transformer handler.
     *
     * @param TransformerHandler $transformer
     *
     * @return self
     */
    public function setTransformerHandler(TransformerHandler $transformer)
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * Set the response HTTP status code.
     *
     * @param  int $code
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
     * @return int
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Make a JSON response.
     *
     * @param  mixed  $data
     * @param  array  $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withJson($data = null, array $headers = [])
    {
        return new JsonResponse($data, $this->statusCode, $headers);
    }

    /**
     * Make a resource response.
     *
     * @param  mixed      $data
     * @param  array|null $meta
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withResource($data, array $meta = null)
    {
        if ($meta) {
            return $this->withJson(compact('data', 'meta'));
        }

        return $this->withJson(compact('data'));
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
            return $this->withJson();
        }

        return $this->withJson([
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

    /**
     * Make a 429 error response.
     *
     * @param  string $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withTooManyRequests($message = 'Too Many Requests')
    {
        return $this->withStatusCode(Response::HTTP_TOO_MANY_REQUESTS)->withError($message);
    }

    /**
     * Make a 201 JSON response.
     *
     * @param  mixed                    $data
     * @param  TransformerAbstract|null $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withCreated($data, TransformerAbstract $transformer = null)
    {
        $this->withStatusCode(Response::HTTP_CREATED);

        if (! $transformer) {
            return $this->withResource($data);
        }

        return $this->withItem($data, $transformer);
    }

    /**
     * Transform a single item.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withItem($data, TransformerAbstract $transformer)
    {
        return $this->withJson(
            $this->transformer->item($data, $transformer)
        );
    }

    /**
     * Transform a collection of items.
     *
     * @param  mixed               $data
     * @param  TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withCollection($data, TransformerAbstract $transformer)
    {
        return $this->withJson(
            $this->transformer->collection($data, $transformer)
        );
    }

    /**
     * Make a collection response with pagination.
     *
     * @param  LengthAwarePaginator $data
     * @param  TransformerAbstract  $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function withPagination(LengthAwarePaginator $data, TransformerAbstract $transformer)
    {
        return $this->withJson(
            $this->transformer->usePaginatorAdapter()->collection($data, $transformer)
        );
    }
}
