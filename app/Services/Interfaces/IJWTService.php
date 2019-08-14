<?php

namespace App\Services\Interfaces;

interface IJWTService
{
    public function getAccessAndRefreshTokens($credentials);

    public function refreshJWT($user);
}