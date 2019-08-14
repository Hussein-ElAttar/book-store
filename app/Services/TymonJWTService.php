<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Cache;
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

        Cache::put($refresh_token, $access_token);

        return compact('access_token', 'refresh_token');
    }

    public function refreshJWT($user)
    {
        $refresh_token    = JWTAuth::getToken();
        $old_access_token = Cache::get($refresh_token);

        // blacklist the old token
        if(!is_null($old_access_token)) {
            JWTAuth::setToken($old_access_token);
            JWTAuth::invalidate();
        }
        $new_access_token = JWTAuth::claims(['type' => 'access_token'])
            ->fromUser($user);

        // store the newly created (latest) access token
        Cache::put($refresh_token, $new_access_token, self::ACCESS_TOKEN_TTL_MINUTES * 60);

        return $new_access_token;
    }
}
