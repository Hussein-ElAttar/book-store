<?php

namespace App\Http\Middleware;

use App\Traits\MapsTymonJwtMiddlewares;
use Closure;
use Tymon\JWTAuth\Http\Middleware\Authenticate;

class JWTAuthenticate extends Authenticate
{
    use MapsTymonJwtMiddlewares;

    public function handle($request, Closure $next)
    {
        $this->mapTymonJwtMiddlewares($request, function(){return true;}, 'access_token');
        return $next($request);
    }
}