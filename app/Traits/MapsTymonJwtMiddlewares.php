<?php
namespace App\Traits;

use Closure;
use Exception;
use App\Exceptions\CustomException;
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
            throw new CustomException(ExceptionConstants::TOKEN_INVALID);
        }

        $user = JWTAuth::user() ?? auth('api')->user();

        if (is_null($user)){
            throw new CustomException(ExceptionConstants::TOKEN_USER_WAS_REMOVED);
        }

        auth('api')->setUser($user);
        Auth::setUser($user);

        return $response;
    }
}
