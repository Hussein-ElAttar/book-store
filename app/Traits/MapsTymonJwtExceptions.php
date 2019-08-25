<?php
namespace App\Traits;

use App\Exceptions\CustomException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\ExceptionConstants;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

trait MapsTymonJwtExceptions {

    public function mapTymonJwtExceptions($exception, $token_type = null){
        if($exception->getMessage()==='Token not provided'){
            throw new CustomException(ExceptionConstants::TOKEN_NOT_PROVIDED);
        };

        $exception=$exception->getPrevious();

        if ($exception instanceof TokenExpiredException) {
            $payload = JWTAuth::manager()->getJWTProvider()->decode(JWTAuth::getToken()->get());
            if($payload && $payload['type'] !== $token_type){
                throw new CustomException(ExceptionConstants::TOKEN_INVALID);
            }
            throw new CustomException(ExceptionConstants::TOKEN_EXPIRED);
        } else if ($exception instanceof TokenBlacklistedException) {
            throw new CustomException(ExceptionConstants::TOKEN_BLACKLISTED);
        } else {
            throw new CustomException(ExceptionConstants::TOKEN_INVALID);
        }
    }
}
