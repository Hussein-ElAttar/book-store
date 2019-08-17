<?php

namespace App\Exceptions\Resource;

use App\Exceptions\CustomException;

class ResourceNotFoundException extends CustomException
{
    public $message  = "Resource Not Found";
    public $httpCode = 403;
}