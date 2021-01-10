<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException){
            if ($exception->getMessage() === 'Token not provided')
                return response()->json(['status' => -1, 'message' => $exception->getMessage()], $exception->getStatusCode());
            elseif ($exception->getMessage() === 'Token has expired')
                return response()->json(['status' => -2, 'message' => $exception->getMessage()], $exception->getStatusCode());
            elseif ($exception->getMessage() === 'Forbidden')
                return response()->json(['status' => -3, 'message' => $exception->getMessage()], $exception->getStatusCode());
            else
                return response()->json(['status' => -999, 'message' => $exception->getMessage()], $exception->getStatusCode());
        }

        return response()->json(['message' => $exception->getMessage()], $exception->getStatusCode());
    }
}
