<?php

namespace App\Src\Jwt;

use Tymon\JWTAuth\Token;
use App\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\ExceptionConstants;
use Tymon\JWTAuth\Manager as TymonManager;

class Manager extends TymonManager
{
    public function refresh(Token $token, $forceForever = false, $resetClaims = false)
    {
        $decoded = $this->decode($token);
        if(JWTAuth::parseToken()->getClaim('type') !== 'refresh_token'){
            throw new JWTException(ExceptionConstants::TOKEN_INVALID);
        }
        $this->setRefreshFlow();
        $claims = $this->buildRefreshClaims($decoded);
        $claims['type'] = 'access_token';

        return $this->encode(
            $this->payloadFactory->customClaims($claims)->make($resetClaims)
        );
    }
}

