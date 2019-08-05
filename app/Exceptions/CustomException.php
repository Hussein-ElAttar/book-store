<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $httpCode;

    public function __construct($msg, $httpCode) {
        $this->message  = $msg;
        $this->httpCode = $httpCode;
    }

    public function getErrorMessage() {
        return $this->message;
    }

    public function getErrorHttpCode() {
        return $this->httpCode;
    }
}
