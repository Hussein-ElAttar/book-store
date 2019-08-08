<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\JWTException;
use App\Exceptions\Interfaces\ICustomException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Tymon JWT Exceptions
        if ($exception instanceof TokenExpiredException)
        {
            return response()->json(['message' => 'Token expired'], 401);
        }
        else if ($exception instanceof TokenInvalidException)
        {
            return response()->json(['message' => 'Invalid token'], 401);
        }
        else if ($exception instanceof TokenBlacklistedException) {
            return response()->json(['message' => 'Token Blacklisted'], 401);
        }
        if ($exception instanceof ICustomException) {
            return response()->json(
                ['message' => $exception->getErrorMessage()], $exception->getErrorHttpCode()
            );
        }
        return parent::render($request, $exception);
    }
}
