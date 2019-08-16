<?php

namespace App\Lib\Responses;

class Response
{
    public $success;
    public $message;
    public $data;
    public $errors;

    public function __toString()
    {
        return json_encode([
            "message" => $this->message,
            "success" => $this->success,
            "data"    => $this->data,
            "errors"  => $this->errors
         ]);
    }
}