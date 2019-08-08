<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\JWTBaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class JWTAuthenticate extends JWTBaseMiddleware
{
    public function handle($request, Closure $next)
    {
        $this->authenticate($request);
        return $next($request);

    }

    /**
     * Attempt to authenticate a user via the token in the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     *
     * @return void
     */
    public function authenticate(Request $request)
    {
        $this->checkForToken($request);
        try {
            $token = $this->auth->parseToken();
        } catch (JWTException $e) {
            throw new JWTException($e->getMessage(), 400);
        }
        if($token->getClaim('type') === 'refresh_token'){
            throw new JWTException('invalid token', 401);
        }
        if (is_null(auth('api')->user())){
            throw new JWTException('User not found', 400);
        }
        Auth::setUser(auth('api')->user());
    }
}