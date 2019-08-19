<?php
namespace App\Traits;

use Closure;
use Exception;
use App\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Constants\ExceptionConstants;

trait MapsTymonJwtMiddlewares {

    use MapsTymonJwtExceptions;

    public function MapTymonJwtMiddlewares($request, Closure $next, $token_type = null)
    {
        try {
            $response = parent::handle($request, $next);
        } catch (Exception $e) {
            $this->mapTymonJwtExceptions($e, $token_type);
        }

        $payload = JWTAuth::manager()->getJWTProvider()->decode(JWTAuth::getToken()->get());

        if($payload && $payload['type'] !== $token_type){
            throw new JWTException(ExceptionConstants::TOKEN_INVALID);
        }

        if (is_null(auth('api')->user())){
            throw new JWTException(ExceptionConstants::TOKEN_USER_WAS_REMOVED);
        }
        Auth::setUser(auth('api')->user());

        return $response;
    }
}
