<?php
namespace App\Traits;

use App\Exceptions\CustomException;

trait Permissible {
    public function assertUserCan($permission){
        $isAuthorized = auth('api')->user()->hasPermissionTo($permission);
        if($isAuthorized === false){
            throw new CustomException("Forbidden", 403);
        }
    }
}
