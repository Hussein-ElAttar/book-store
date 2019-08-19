<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\MapsTymonJwtMiddlewares;
use Tymon\JWTAuth\Http\Middleware\RefreshToken;

class JWTRefresh extends RefreshToken
{
    use MapsTymonJwtMiddlewares;

    public function handle($request, Closure $next)
    {
        return $this->MapTymonJwtMiddlewares($request, $next, 'refresh_token');
    }
}
