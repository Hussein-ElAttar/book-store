<?php

namespace App\Exceptions;

use Exception;
use App\Exceptions\Interfaces\ICustomException;

class CustomException extends Exception implements ICustomException
{
    protected $statusCode = 400;
    protected $errors;

    public function __construct($const = [], $errors = []) {
        if(is_array($const)){
            $this->message  = $const[0] ?? '';
            $this->statusCode = $const[1] ?? $this->statusCode;
        }
        else if(is_int($const))
        {
            $this->message  = '';
            $this->statusCode = $const;
        }
        else if(is_string($const))
        {
            $this->message  = $const;
        }

        $this->errors = $errors;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getErrors() {
        return $this->errors;
    }
}
