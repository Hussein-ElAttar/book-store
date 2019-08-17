<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;
use App\Exceptions\JWT\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\JWTBaseMiddleware;

class JWTRefresh extends JWTBaseMiddleware
{
    public function handle($request, Closure $next)
    {
        $this->checkForToken($request);

        $payload = JWTAuth::parseToken()->getPayload();
        if($payload->get('type') !== 'refresh_token'){
            throw new JWTException('Invalid token', 400);
        }
        Auth::setUser(auth('api')->user());

        return $next($request);
    }
}
