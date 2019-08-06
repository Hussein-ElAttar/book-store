<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Exceptions\JWTException;
use \Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTBaseMiddleware extends BaseMiddleware
{
    public function checkForToken(Request $request)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            throw new JWTException('Token not provided', 401);
        }
    }
}