<?php

namespace App\Services\Interfaces;

interface IJWTService
{
    public function authenticate($credentials);

    public function refreshJWT($token);

    public function revokeJWT($token);
}