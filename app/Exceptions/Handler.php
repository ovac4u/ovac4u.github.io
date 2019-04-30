<?php

namespace App\Exceptions;

use Exception;
use Flugg\Responder\Exceptions\Handler as ExceptionHandler;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * @param  \Exception               $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson()) {
            if ($exception instanceof TokenBlacklistedException) {
                return responder()->error('token_expired', $exception->getMessage())->respond(401);
            }

            if ($exception instanceof TokenExpiredException) {
                return responder()->error('token_expired', $exception->getMessage())->respond(401);
            }

            if ($exception instanceof TokenInvalidException) {
                return responder()->error('token_invalid', $exception->getMessage())->respond(401);
            }

            if ($exception instanceof JWTException) {
                return responder()->error('token_absent', $exception->getMessage())->respond(401);
            }
        }

        return parent::render($request, $exception);
    }
}
