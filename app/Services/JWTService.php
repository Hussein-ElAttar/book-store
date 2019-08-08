<?php

namespace App\Services;

use App\Exceptions\CustomException;

class JWTService{
    public function getAccessAndRefreshTokens($credentials)
    {
        $access_token = auth('api')->claims(['type' => 'access_token'])
            ->attempt($credentials);

        if (! $access_token) {
            throw new CustomException('Unauthorized', 401);
        }

        $refresh_token = auth('api')->claims(['type' => 'refresh_token'])
            ->setTTL(100)->attempt($credentials);

        return compact('access_token', 'refresh_token');
    }

    public function refreshJWT()
    {
        return JWTAuth::claims(['type' => 'access_token'])
            ->fromUser(auth('api')->user());
    }
}