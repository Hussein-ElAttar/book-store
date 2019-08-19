<?php
namespace App\Traits;

use App\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\ExceptionConstants;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

trait MapsTymonJwtExceptions {

    public function mapTymonJwtExceptions($exception, $token_type = null){
        if($exception->getMessage()==='Token not provided'){
            throw new JWTException('Token not provided', 401);
        };

        $exception=$exception->getPrevious();

        if ($exception instanceof TokenExpiredException) {
            $payload = JWTAuth::manager()->getJWTProvider()->decode(JWTAuth::getToken()->get());
            if($payload && $payload['type'] !== $token_type){
                throw new JWTException(ExceptionConstants::TOKEN_INVALID);
            }
            throw new JWTException(ExceptionConstants::TOKEN_EXPIRED);
        } else if ($exception instanceof TokenBlacklistedException) {
            throw new JWTException(ExceptionConstants::TOKEN_BLACKLISTED);
        } else {
            throw new JWTException(ExceptionConstants::TOKEN_INVALID);
        }
    }
}
