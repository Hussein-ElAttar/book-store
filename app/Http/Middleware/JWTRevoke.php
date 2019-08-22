<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;
use App\Constants\ExceptionConstants;
use App\Traits\MapsTymonJwtExceptions;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTRevoke extends BaseMiddleware
{
    use MapsTymonJwtExceptions;

    public function handle($request, Closure $next)
    {
        try {
            parent::authenticate($request, $next);
        } catch (Exception $e) {
            $this->mapTymonJwtExceptions($e);
        }
        if (is_null(auth('api')->user())){
            throw new CustomException(ExceptionConstants::TOKEN_USER_WAS_REMOVED);
        }
        Auth::setUser(auth('api')->user());

        return $next($request);
    }
}
