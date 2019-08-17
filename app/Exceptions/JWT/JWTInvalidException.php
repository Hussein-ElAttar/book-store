<?php

namespace App\Exceptions\JWT;
class JWTInvalidException extends CustomException
{
    public $message  = "Invalid Token";
    public $httpCode = 401;
}