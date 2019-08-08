<?php

namespace App\Services;

class JWTService{
    public function getAccessAndRefreshTokens($credentials)
    {
        $access_token = auth('api')->claims(['type' => 'access_token'])
            ->attempt($credentials);

        if (! $access_token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $refresh_token = auth('api')->claims(['type' => 'refresh_token'])
            ->setTTL(100)->attempt($credentials);

        return compact('access_token', 'refresh_token');
    }
}