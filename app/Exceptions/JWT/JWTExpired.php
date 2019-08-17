<?php

namespace App\Exceptions\JWT;

class JWTExpired extends CustomException
{
    public $message  = "Token Expired";
    public $httpCode = 403;
}