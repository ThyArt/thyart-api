<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     * @throws \ReflectionException
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'model_not_found',
                'message' => (new \ReflectionClass($exception->getModel()))->getShortName() . ' with such parameters does not exists.'
            ], 404);
        } elseif ($exception instanceof UnauthorizedException) {
            return response()->json([
                'error' => 'unauthorized',
                'message' => $exception->getMessage()
            ], 403);
        } elseif ($exception instanceof ValidationException) {
            return response()->json([
                'error' => 'validation_failed',
                'messages' => $exception->validator->errors()->all()
            ], 400);
        }

        return parent::render($request, $exception);
    }
}
