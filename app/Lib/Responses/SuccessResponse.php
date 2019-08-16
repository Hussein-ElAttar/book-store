<?php

namespace App\Lib\Responses;
use App\Lib\Responses\Response;

class SuccessResponse extends Response
{
    public function __construct($data=NULL, $message=NULL){
        $this->success = 1;
        $this->message = $message;
        $this->data    = $data;
   }
}