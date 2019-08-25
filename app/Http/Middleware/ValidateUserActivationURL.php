<?php

namespace App\Http\Middleware;

use App\Constants\ExceptionConstants;
use Closure;

use App\Exceptions\CustomException;

class ValidateUserActivationURL
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasValidSignature())
        {
            throw new CustomException(ExceptionConstants::URL_INVALID);
        }

        return $next($request);
    }
}

