<?php

namespace App\Exceptions;

use Exception;
use App\Services\ResponseService;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\Interfaces\ICustomException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorizedException;

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
        // Spatie Exceptions
        if ($exception instanceof SpatieUnauthorizedException)
        {
            return ResponseService::getFailureResponse(
                $exception->getCode(),
                [],
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }

        // Tymon JWT Exceptions
        if ($exception instanceof JWTException)
        {
            return ResponseService::getFailureResponse(
                $exception->getCode(),
                [],
                $exception->getMessage()
            );
        }

        // Custom App Exceptions
        if ($exception instanceof ICustomException) {
            return ResponseService::getFailureResponse(
                $exception->getCode(),
                $exception->getErrors(),
                $exception->getMessage(),
                $exception->getStatusCode()
            );
        }

        return ResponseService::getFailureResponse(
            $exception->getCode(),
            [],
            $exception->getMessage()
        );

        return parent::render($request, $exception);
    }
}
