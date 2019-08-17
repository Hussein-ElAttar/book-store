<?php

namespace App\Exceptions\Resource;

use App\Exceptions\CustomException;

class ResourceForbiddenAccessException extends CustomException
{
    public $message  = "Forbidden access to this resource";
    public $httpCode = 404;
}