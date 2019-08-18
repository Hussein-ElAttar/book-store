<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $httpCode = 400;

    public function __construct($const = []) {
        if(is_array($const)){
            $this->message  = $const[0] ?? '';
            $this->httpCode = $const[1] ?? $this->httpCode;
        }
        else if(is_int($const))
        {
            $this->message  = '';
            $this->httpCode = $const;
        }
        else if(is_string($const))
        {
            $this->message  = $const;
        }
    }

    public function getErrorMessage() {
        return $this->message;
    }

    public function getErrorHttpCode() {
        return $this->httpCode;
    }
}
