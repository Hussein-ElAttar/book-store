<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\CustomException;
use App\Services\Interfaces\IJWTService;

class TymonJWTService implements IJWTService
{
    const REFRESH_TOKEN_TTL_MINTUES = 60*24; // 24 hours
    const ACCESS_TOKEN_TTL_MINUTES  = 60; // 1 hour

    public function getAccessAndRefreshTokens($credentials)
    {
        $access_token = auth('api')->claims(['type' => 'access_token'])
            ->attempt($credentials);

        if (! $access_token) {
            throw new CustomException('Unauthorized', 401);
        }

        $refresh_token = auth('api')->claims(['type' => 'refresh_token'])
            ->setTTL(self::REFRESH_TOKEN_TTL_MINTUES)->attempt($credentials);

        return compact('access_token', 'refresh_token');
    }

    public function refreshJWT()
    {
        // token is already refreshed within the middleware
        return JWTAuth::getToken()->get();
    }

    public function revokeJWT($token){
        JWTAuth::setToken($token);
        JWTAuth::invalidate();

        return $token;
    }
}
