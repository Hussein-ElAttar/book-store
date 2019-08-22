<?php

namespace App\Services;

use App\Constants\ExceptionConstants;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\CustomException;
use App\Services\Interfaces\IJWTService;

class JWTService implements IJWTService
{
    const REFRESH_TOKEN_TTL_MINTUES = 60*24; // 24 hours
    const ACCESS_TOKEN_TTL_MINUTES  = 60; // 1 hour

    public function authenticate($credentials)
    {
        $access_token = auth('api')->claims(['type' => 'access_token'])
            ->attempt($credentials);

        if (! $access_token) {
            throw new CustomException(ExceptionConstants::USER_WRONG_EMAIL_OR_PASS);
        }

        $refresh_token = auth('api')->claims(['type' => 'refresh_token'])
            ->setTTL(self::REFRESH_TOKEN_TTL_MINTUES)->fromUser(auth('api')->user());

        return compact('access_token', 'refresh_token');
    }

    public function refreshJWT($refreshToken)
    {
        JWTAuth::setToken($refreshToken);

        $accessToken = JWTAuth::parseToken()->refresh();

        return $accessToken;
    }

    public function revokeJWT($token){
        JWTAuth::setToken($token);
        JWTAuth::invalidate();

        return $token;
    }
}
