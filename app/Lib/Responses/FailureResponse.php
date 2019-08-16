<?php

namespace App\Lib\Responses;
use App\Lib\Responses\Response;

class FailedResponse extends Response
{
    public function __construct($errors=NULL, $message=NULL){
        $this->success = 0;
        $this->message = $message;
        $this->errors  = $errors;
   }
}