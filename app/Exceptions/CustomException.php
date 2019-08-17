<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $httpCode;

    public function __construct($msg=NULL) {
        if(!is_null($msg)){
            $this->message = $msg;
        }
    }

    public function getErrorMessage() {
        return $this->message;
    }

    public function getErrorHttpCode() {
        return $this->httpCode;
    }
}
