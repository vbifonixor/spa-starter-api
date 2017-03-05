<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($request->expectsJson()) {
            return $this->handleJsonResponse($request, $e);
        }

        return parent::render($request, $e);
    }

    /**
     * Handle the JSON response error format.
     *
     * @param  Request   $request
     * @param  Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleJsonResponse(Request $request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return $this->handleValidationExceptionResponse($exception);
        }

        if ($exception instanceof HttpException) {
            return $this->handleHttpExceptionResponse($exception);
        }

        return $this->makeJsonErrorResponse($exception->getMessage(), 500);
    }

    /**
     * Handle HTTP exceptions response.
     *
     * @param  Exception $exception
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleHttpExceptionResponse(Exception $exception)
    {
        $code = $exception->getStatusCode();
        $message = Response::$statusTexts[$code];

        return $this->makeJsonErrorResponse($message, $code);
    }

    /**
     * Handler validation exceptions response.
     *
     * @param  Exception $exception
     *
     * @return \Illuminate\Http\Response
     */
    protected function handleValidationExceptionResponse(Exception $exception)
    {
        return $exception->getResponse();
    }

    /**
     * Make a JSON response error.
     *
     * @param  string $message
     * @param  int    $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeJsonErrorResponse($message, $code)
    {
        return new JsonResponse([
            'errors' => [$message],
        ], $code);
    }
}
