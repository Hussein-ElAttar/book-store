<?php

namespace App\Http\Middleware;

use Closure;

use App\Exceptions\CustomException;

class ValidateEmailVerificationURL
{
    public function handle($request, Closure $next)
    {
        if (!$request->hasValidSignature())
        {
            throw new CustomException('Invalid url', 400);
        }

        return $next($request);
    }
}

